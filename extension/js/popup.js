let APP, API_DOMAIN, MARKETPLACE_DOMAIN, INFLUENCER = []
let access_token, domain
let contact = null, opportunity = false, nocontact = true, inquiry = true, feedback = true

$(() => {
    $(document).on('click', '.alert .close', e => {
        const that = $(e.target)
        that.parent().hide().find('span').html('')
        CloseNotification(that)
    })

    $(document).on('keydown', '.models', e => {
        $(`#${e.target.id}-error`).html('').hide()
    }).on('change', '[name="opportunities[]"]', e => {
        $(`#opportunities-error`).html('').hide()
    })

    $(document).on('keypress', '.auth-page input', e => {
        e.keyCode == 13 && Login()
    })

    $(document).on('click', '#login-button', () => {
        Login()
    })

    $(document).on('click', '#forgot-password', () => {
        chrome.tabs.create({url: `${MARKETPLACE_DOMAIN}/forgot-password`})
    })

    $(document).on('click', '#new-account', () => {
        chrome.tabs.create({url: `${MARKETPLACE_DOMAIN}/create-profile`})
    })

    $(document).on('click', '#show-more-noti', () => {
        chrome.tabs.create({url: `${MARKETPLACE_DOMAIN}/dashboard`})
    })

    $(document).on('click', '#manage-account', () => {
        GotoPage('manage-account')
    })

    $(document).on('click', '#logout', () => {
        Logout()
    })

    $(document).on('click', '#no-contact:not(.disabled)', () => {
        NoContactFound()
    })

    $(document).on('click', '#back-to-contacts', () => {
        LoadContact()
    })

    $(document).on('click', '#add-favorite', () => {
        AddFavorite()
    })

    /*
    $(document).on('click', '#copy-affiliate-link', () => {
        copyAffiliateLink()
    })
    */

    $(document).on('click', '#send-partnership-inquiry', () => {
        if (opportunity) GotoPage('opportunities')
        else SendPartnershipInquiry()
    })

    $(document).on('click', '#feedback-submit-button', () => {
        SubmitFeedback()
    })

    $(document).on('click', '#opportunities-inquiry-button', () => {
        SendOpportunitiesInquiry()
    })

    $(document).on('click', '#update-password-button', () => {
        UpdatePassword()
    })

    $(document).on('click', '#request-publisher-button', () => {
        RequestPublisher()
    })

    Init()
})

const HttpRequest = (request) => {
    let {url, method, data} = request
    if (method == 'GET' && data) {
        url = new URL(url)
        for (key in data) url.searchParams.set(key, data[key])
        url = url.toString()
    }
    let body = method == 'POST' && data ? { body: JSON.stringify(data) } : {}
    return fetch(url, {
        method: method,
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${access_token}`,
            'Content-Type': 'application/json'
        },
        ...body
    }).then(response => {
        if ([200, 400, 403, 404, 422].includes(response.status)
            || (response.status == 401 && url.includes('/api/login')))
        {
            return response.json()
        } else if (response.status == 401) {
            Logout()
            throw 'Unauthorized'
        }
        Close()
        throw 500
    })
}

const ToggleLoading = show => show ? $('#loading').show() : $('#loading').hide()

const GotoPage = page => {
    $('.alert:not(.notification)').hide().find('span').html('')
    $('.pages').hide()
    $(`.${page}-page`).show()
    ToggleLoading(false)
}

const Close = (message) => {
    !message && (message = 'A network error (such as timeout, interrupted connection or unreachable host) has occurred.')
    alert(message)
    window.close()
}

const Init = async () => {
    let env = await new Promise(resolve => {
        chrome.runtime.sendMessage({
            signal: 'StartUp'
        }, response => {
            resolve((!chrome.runtime.lastError && response) || {})
        })
    })
    if (!(APP = env.APP) || !(MARKETPLACE_DOMAIN = env.MARKETPLACE_DOMAIN)
        || !(API_DOMAIN = env.API_DOMAIN) || !(INFLUENCER = env.INFLUENCER)
    ) {
        return Close('Something went wrong.')
    }
    if (access_token = ((await chrome.storage.local.get(APP))[APP] || {}).access_token) {
        LoadContact()
        GetNotification()
    }
}

const ClearContact = () => {
    contact = null, opportunity = false
    nocontact = inquiry = feedback = true
    $('#no-contact').addClass('disabled')
    const contact_info =
        `<tr>
            <td class="font-italic small">
                There is no contact information for this site.
            </td>
        </tr>`
    $('#contact-info').html(contact_info)
    $('#add-favorite').hide().find('i').removeClass('fa-heart fa-heart-o').next().text('')
    $('#send-partnership-inquiry').attr('disabled', 'disabled')
    $('#average-response-time').hide().find('b').removeClass('hour1 day1 week1 month1').text('')
    $('#feedback-form-container').hide().find('#feedback-submit-button').attr('disabled', 'disabled')
    $('#site-contact-message').hide().html('')
    $('#opportunities-list').html('')
    $('#opportunities-inquiry-button').attr('disabled', 'disabled')
    $('#blacklist-message').html('Not available at this time')
}

const LoadContact = async () => {
    if (!access_token) return GotoPage('auth')
    ToggleLoading(true)
    ClearContact()
    const tab = (await chrome.tabs.query({ active: true }))[0]
    console.log(tab)
    const url = new URL(tab.url)
    domain = url.hostname
    if (INFLUENCER.includes(domain)) {
        domain = await new Promise(resolve => {
            chrome.tabs.sendMessage(tab.id, {
                signal: 'LoadContacts'
            }, response => {
                resolve((!chrome.runtime.lastError && response.website) || null)
            })
        })
        if (!domain) {
            $('#blacklist-message').html('Proceed to Social Media Profile')
            return GotoPage('blacklist')
        }
    }
    HttpRequest({
        url: `${API_DOMAIN}/api/contact`,
        method: 'GET',
        data: {
            domain: domain
        }
    }).then(data => {
        if (data.success) {
            let {details} = data, icon = (contact = details.contact) ? 'active' : 'default'
            chrome.action.setIcon({ tabId: tab.id, path: `/img/${icon}-icon.png` })
            ToggleLoading(false)
            if (details.blacklist) return GotoPage('blacklist')
            if (!contact) {
                !(nocontact = details.nocontact) && $('#no-contact').removeClass('disabled')
                return GotoPage('nocontact')
            }
            let category = contact.category
            $('.category').html(category)
            let additional = '', opportunities = []
            if (category == 'Brand') {
                $('.category-Brand').show(), $('.category-Creator').hide()
                //$('.category-Brand').show(), $('.category-Affiliate').hide()
                additional =
                    `<div class ="row mt-2">
                        <div class="col-4 font-weight-bold">Network:</div>
                        <div class="col-8 word-break-all">
                            <a href="${contact.network_link}" target="_blank">${contact.network}</a>
                        </div>
                    </div>
                    ${contact.commission &&
                    `<div class ="row mt-2">
                        <div class="col-4 font-weight-bold">Commission:</div>
                        <div class="col-8">${contact.commission}</div>
                    </div>`}`
            } else {
                $('.category-Brand').hide(), $('.category-Creator').show()
                //$('.category-Brand').hide(), $('.category-Affiliate').show()
                try {
                    opportunities = JSON.parse(contact.opportunities)
                } catch(e) {
                    opportunities = []
                }
            }
            const contact_info =
                `<tr>
                    <td class="py-2">
                        <div class ="row">
                            <div class="col-4 font-weight-bold">Name:</div>
                            <div class="col-8 word-break-all">${contact.name}</div>
                        </div>
                        <div class ="row mt-2">
                            <div class="col-4 font-weight-bold">Email:</div>
                            <div class="col-8 word-break-all">${contact.email}</div>
                        </div>
                        ${additional}
                    </td>
                </tr>`
            $('#contact-info').html(contact_info)
            if (contact.favorite) {
                $('#add-favorite').show().find('i').addClass('fa-heart').next().text('Saved in Dashboard')
            } else {
                $('#add-favorite').show().find('i').addClass('fa-heart-o').next().text('Save to Dashboard')
            }
            if (opportunities.length) {
                $('#send-partnership-inquiry').removeAttr('disabled').html('View Opportunities')
                let opportunities_list = ''
                opportunities.forEach(opportunity => {
                    const description = opportunity.description
                    const price = opportunity.cost_type == 'dollar' ? `$${opportunity.cost}` : opportunity.cost_type
                    const ref = opportunity.ref
                    opportunities_list +=
                        `<label class="input-group">
                            <div class="form-control px-1">${description}</div>
                            <div class="input-group-append">
                                <span class="input-group-text px-1 py-0 small">${price}</span>
                                <div class="input-group-text bg-white">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="opportunities[]" value="${ref}" class="custom-control-input models">
                                        <span class="custom-control-label"></span>
                                    </div>
                                </div>
                            </div>
                        </label>`
                })
                $('#opportunities-list').html(opportunities_list)
                $('#opportunities-inquiry-button').removeAttr('disabled')
                opportunity = true
            } else {
                if (!(inquiry = contact.inquiry)) {
                    $('#send-partnership-inquiry').removeAttr('disabled').html('Send Partnership Inquiry')
                } else {
                    $('#send-partnership-inquery').attr('disabled', 'disabled').html('<i class="fa fa-check"></i>')
                }
            }
            let textlabel = '', classname  = ''
            switch (contact.response_time) {
                case 1: textlabel = '1 Hour'; classname = 'hour1'; break
                case 2: textlabel = '1 Day'; classname = 'day1'; break
                case 3: textlabel = '1 Week'; classname = 'week1'; break
                case 4: textlabel = '1 Month'; classname = 'month1'; break
            }
            if (textlabel) {
                $('#average-response-time').show().find('b').addClass(classname).text(textlabel)
            }
            !(feedback = contact.feedback) && $('#feedback-form-container').show().find('#feedback-submit-button').removeAttr('disabled')
            let message = `If this contact information is incorrect or outdated, please email: <b>${details.contact_email}</b>`
            $('#site-contact-message').show().html(message)
            GotoPage('contact')
        }
    })
}

const GetNotification = () => {
    if (!access_token) return GotoPage('auth')
    HttpRequest({
        url: `${API_DOMAIN}/api/notifications`,
        method: 'GET'
    }).then(data => {
        if (data.details.notifications.length) {
            let notifications_list = ''
            data.details.notifications.forEach(noti => {
                notifications_list +=
                    `<div class="alert alert-info alert-dismissible notification small mb-1" style="display:block">
                        <button type="button" class="close" data-ref="${noti.id}">&times;</button>` +
                        (noti.opportunity ?
                        `<span>${noti.user} is interested in one of your opportunities!</span>` :
                        `<span>${noti.user} wants to partner with you!</span>`) +
                    `</div>`
            })
            if (data.details.notifications.length == 5) {
                notifications_list +=
                    `<div class="text-center">
                        <a id="show-more-noti" href="#" class="small">Show more</a>
                    </div>`
            }
            $('#notifications').html(notifications_list).show()
        } else {
            $('#notifications').html('').hide()
        }
        if (data.details.ad) {
            $('#ads-support').show()
                .find('a').attr('href', data.details.ad.link)
                .find('img').attr('src', data.details.ad.image)
        } else {
            $('#ads-support').hide()
            .find('a').attr('href', '')
            .find('img').attr('src', '')
        }
        setTimeout(GetNotification, 5000)
    })
}

const Login = () => {
    const email = $('#login-email').val(), password = $('#login-password').val()
    if (!email) {
        return $('#login-email-error').html('Please input email.').show()
    } else if (!password) {
        return $('#login-password-error').html('Please input password.').show()
    }
    ToggleLoading(true)
    HttpRequest({
        url: `${API_DOMAIN}/api/login`,
        method: 'POST',
        data: {
            email: email,
            password: password
        }
    }).then(data => {
        if (data.success) {
            $('#login-email').val(''), $('#login-password').val('')
            $('#login-message').hide().find('span').html('')
            chrome.storage.local.set({
                [APP]: { access_token: access_token = data.access_token }
            })
            GotoPage('splash')
            GetNotification()
        } else {
            $('#login-message').show().find('span').html(data.message)
        }
        ToggleLoading(false)
    })
}

const Logout = () => {
    ClearContact(), GotoPage('auth'), ToggleLoading(false)
    access_token = domain = contact = null
    nocontact = inquiry = feedback = true
    chrome.runtime.sendMessage({
        signal: 'Logout'
    }, () => chrome.runtime.lastError)
}

const NoContactFound = () => {
    if (!access_token) return GotoPage('auth')
    if (contact || !domain) return Close()
    if (nocontact) {
        return $('#no-contact').addClass('disabled')
    }
    ToggleLoading(true)
    HttpRequest({
        url: `${API_DOMAIN}/api/no-contact-found`,
        method: 'POST',
        data: {
            domain: domain
        }
    }).then(data => {
        ToggleLoading(false)
        if (data.success) {
            nocontact = true
            $('#no-contact').addClass('disabled')
            $('#no-contact-success-loading').show()
            setTimeout(() => $('#no-contact-success-loading').hide(), 2000)
        } else {
            $('#no-contact-failed-loading').show()
            setTimeout(() => $('#no-contact-failed-loading').hide(), 2000)
        }
    })
}

const AddFavorite = () => {
    if (!access_token) return GotoPage('auth')
    if (!contact || !domain) return Close()
    ToggleLoading(true)
    HttpRequest({
        url: `${API_DOMAIN}/api/add-favorite`,
        method: 'POST',
        data: {
            domain: domain
        }
    }).then(data => {
        if (data.success) {
            if (data.details.favorite) {
                $('#add-favorite').show().find('i').removeClass('fa-heart-o').addClass('fa-heart').next().text('Saved in Dashboard')
            } else {
                $('#add-favorite').show().find('i').removeClass('fa-heart').addClass('fa-heart-o').next().text('Save to Dashboard')
            }
        }
        ToggleLoading(false)
    })
}

/*
const copyAffiliateLink = () => {
    if (contact && contact.affiliate_link) {
        $('#copy-affiliate-link').html('<i class="fa fa-check"></i>').attr('disabled', 'disabled')
        const value = contact.affiliate_link
        if (navigator.clipboard) {
            navigator.clipboard.writeText(value).then(function() {
            }, function(err) {
            })
        } else {
            if (fallbackCopyTextToClipboard(value)) {
            }
        }
        setTimeout(() => {
            $('#copy-affiliate-link').html('Copy Affiliate Link <i class="fa fa-copy"></i>').removeAttr('disabled')
        }, 1000)
    }
}

function fallbackCopyTextToClipboard(text) {
    let textArea = document.createElement("textarea")
    textArea.value = text
    textArea.style.top = "0"
    textArea.style.left = "0"
    textArea.style.position = "fixed"
    document.body.appendChild(textArea)
    textArea.focus()
    textArea.select()
    let copied = false
    try {
        document.execCommand('copy')
        copied = true
    } catch (err) {
    }
    document.body.removeChild(textArea)
    return copied
}
*/

const SendPartnershipInquiry = () => {
    if (!access_token) return GotoPage('auth')
    if (!contact || !domain) return Close()
    if (inquiry) {
        return $('#send-partnership-inquiry').attr('disabled', 'disabled').html('<i class="fa fa-check"></i>')
    }
    ToggleLoading(true)
    HttpRequest({
        url: `${API_DOMAIN}/api/partnership-inquiry`,
        method: 'POST',
        data: {
            domain: domain
        }
    }).then(data => {
        if (data.success) {
            inquiry = true
            $('#send-partnership-inquiry').attr('disabled', 'disabled').html('<i class="fa fa-check"></i>')
            $('#inquiry-success-message').show().find('span').html('Your partnership inquiry has been successfully submitted.')
        } else {
            $('#send-partnership-inquiry').attr('disabled', 'disabled')
        }
        ToggleLoading(false)
    })
}

const SendOpportunitiesInquiry = () => {
    if (!access_token) return GotoPage('auth')
    if (!contact || !domain) return Close()
    let opportunities = []
    $('[name="opportunities[]"]:checked').each(function() {
        opportunities.push($(this).val())
    })
    if (!opportunities.length) {
        return $('#opportunities-error').html('Please select an opportunity.').show()
    }
    ToggleLoading(true)
    $('#opportunities-inquiry-button').attr('disabled', 'disabled')
    HttpRequest({
        url: `${API_DOMAIN}/api/opportunities-inquiry`,
        method: 'POST',
        data: {
            domain: domain,
            opportunities: opportunities
        }
    }).then(data => {
        if (data.success) {
            $('#opportunities-success-message').show().find('span').html('Your opportunities inquiry has been successfully submitted.')
        } else if (data.errors) {
            $('#opportunities-error').html(data.errors.opportunities[0]).show()
        } else {
            $('#opportunities-error-message').show().find('span').html(data.message || 'Something went wrong.')
            if (!data.message) return Close()
        }
        $('#opportunities-inquiry-button').removeAttr('disabled')
        ToggleLoading(false)
    })
}

const SubmitFeedback = () => {
    if (!access_token) return GotoPage('auth')
    if (!contact || !domain) return Close()
    if (feedback) {
        return $('#feedback-error-message').show().find('span').html('Cannot submit feedback for this site.')
    }
    ToggleLoading(true)
    const time = $('#feedback-response-time').val(), comment = $('#feedback-comment').val()
    HttpRequest({
        url: `${API_DOMAIN}/api/feedback`,
        method: 'POST',
        data: {
            domain: domain,
            response_time: time,
            comment: comment
        }
    }).then(data => {
        if (data.success) {
            feedback = true
            $('#feedback-form-container').hide()
            $('#feedback-success-message').show().find('span').html('Feedback has been successfully submitted.')
        } else {
            $('#feedback-error-message').show().find('span').html(data.message)
        }
        ToggleLoading(false)
    })
}

const UpdatePassword = () => {
    if (!access_token) return GotoPage('auth')
    const current_password = $('#account-current-password').val()
    const password = $('#account-password').val()
    const password_confirmation = $('#account-password-confirm').val()
    if (!current_password) {
        return $('#account-current-password-error').html('Please input current password.').show()
    } else if (!password) {
        return $('#account-password-error').html('Please input password.').show()
    } else if (password != password_confirmation) {
        return $('#account-password-error').html('Password confirmation does not match.').show()
    }
    ToggleLoading(true)
    HttpRequest({
        url: `${API_DOMAIN}/api/update-password`,
        method: 'POST',
        data: {
            current_password: current_password,
            password: password,
            password_confirmation: password_confirmation
        }
    }).then(data => {
        if (data.success) {
            $('#account-password-success-message').show().find('span').html('Your password has been updated successfully.')
        } else {
            $('#account-password-error-message').show().find('span').html(data.message)
        }
        ToggleLoading(false)
    })
}

const RequestPublisher = () => {
    if (!access_token) return GotoPage('auth')
    const message = $('#request-publisher-message').val()
    if (!message) {
        return $('#request-publisher-message-error').html('Please input message.').show()
    }
    ToggleLoading(true)
    HttpRequest({
        url: `${API_DOMAIN}/api/request-publisher`,
        method: 'POST',
        data: {
            message: message
        }
    }).then(data => {
        if (data.success) {
            $('#request-publisher-success-message').show().find('span').html('Your request has been successfully submitted.')
        } else {
            $('#request-publisher-error-message').show().find('span').html(data.message)
        }
        ToggleLoading(false)
    })
}

const CloseNotification = that => {
    if (!that) return
    const ref = that.data('ref')
    if (!ref) return
    HttpRequest({
        url: `${API_DOMAIN}/api/clear-noti`,
        method: 'GET',
        data: {
            noti: ref
        }
    })
    .then(data => {
        if (data.success) that.parent().remove()
    })
}

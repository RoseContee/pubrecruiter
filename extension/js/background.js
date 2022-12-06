const APP = 'Pub Recruiter'
const API_DOMAIN = 'https://extension.pubrecruiter.com'
const MARKETPLACE_DOMAIN = 'https://marketplace.pubrecruiter.com'

const INFLUENCER = [
    "www.youtube.com",
    "www.facebook.com",
    "twitter.com",
    "www.tiktok.com"
]

chrome.runtime.onMessage.addListener(async (message, sender, response) => {
    if (message.signal == 'StartUp') {
        response({
            APP: APP,
            API_DOMAIN: API_DOMAIN,
            MARKETPLACE_DOMAIN: MARKETPLACE_DOMAIN,
            INFLUENCER: INFLUENCER
        })
    } else if (message.signal == 'Logout') {
        const tabs = await chrome.tabs.query({})
        tabs.forEach(tab => {
            chrome.action.setIcon({ tabId: tab.id, path: '/img/default-icon.png' })
        })
        chrome.storage.local.remove(APP)
    }
})

chrome.tabs.onActivated.addListener(({tabId}) => {
    setActionIcon(tabId)
})

chrome.tabs.onUpdated.addListener((tabId, info, tab) => {
    if (info.status == 'complete' && tab.url) {
        setActionIcon(tabId, tab)
    }
})

const setActionIcon = async (tabId, tab) => {
    const access_token = ((await chrome.storage.local.get(APP))[APP] || {}).access_token
    if (!access_token) return
    !tab && (tab = await chrome.tabs.get(tabId))
    if (!tab || !tab.url) return
    const url = new URL(tab.url)
    let domain = url.hostname
    if (INFLUENCER.includes(domain)) {
        domain = await new Promise(resolve => {
            chrome.tabs.sendMessage(tabId, {
                signal: 'LoadContacts'
            }, response => {
                resolve((!chrome.runtime.lastError && response.website) || null)
            })
        })
        if (!domain) {
            return chrome.action.setIcon({ tabId: tabId, path: '/img/default-icon.png' })
        }
    }
    fetch(`${API_DOMAIN}/api/contact?domain=${domain}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${access_token}`
        },
    })
    .then(response => response.json())
    .then(data => {
        const icon = data.success && data.details.contact ? 'active' : 'default'
        chrome.action.setIcon({ tabId: tabId, path: `/img/${icon}-icon.png` })
    })
}

const sleep = delay => new Promise(resolve => setTimeout(resolve, delay))

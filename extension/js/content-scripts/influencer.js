chrome.runtime.onMessage.addListener(function(message, sender, response) {
    if (message.signal == 'LoadContacts') {
        console.log(message)
        let website = '', pos = -1
        let {hostname, origin, pathname} = location
        //https://www.youtube.com/channel/USERNAME
        //https://www.youtube.com/user/USERNAME
        //https://www.youtube.com/c/USERNAME
        if (hostname == 'www.youtube.com' &&
            document.querySelector('meta[property="og:type"][content="profile"]') &&
            ((pathname.indexOf('/channel/') == 0 && (pos = 9))
                || (pathname.indexOf('/user/') == 0 && (pos = 5))
                || (pathname.indexOf('/c/') == 0 && (pos = 3)))
        ) {
            if ((pos = pathname.indexOf('/', pos)) > 0) {
                pathname = pathname.substring(0, pos)
            }
            website = origin + pathname
        //https://www.facebook.com/USERNAME
        //https://www.facebook.com/groups/USERNAME
        } else if (hostname == 'www.facebook.com' &&
            (((document.querySelector('[data-pagelet="ProfileTabs"]') || document.querySelector('[aria-label="Message"]'))
                    && (pos = 1)
                ) || (pathname.indexOf('/groups/') == 0 && (pos = 8)))
        ) {
            if ((pos = pathname.indexOf('/', pos)) > 0) {
                pathname = pathname.substring(0, pos)
            }
            if (pathname.indexOf('/profile.php') == 0 && (id = (new URLSearchParams(location.search)).get('id'))) {
                pathname = `/profile.php?id=${id}`
            }
            website = origin + pathname
        //https://twitter.com/USERNAME
        } else if (hostname == 'twitter.com' &&
            document.querySelector('meta[property="og:type"][content="profile"]') &&
            (pos = 1)
        ) {
            if ((pos = pathname.indexOf('/', pos)) > 0) {
                pathname = pathname.substring(0, pos)
            }
            website = origin + pathname
        //https://www.tiktok.com/@USERNAME
        } else if (hostname == 'www.tiktok.com' &&
            document.querySelector('meta[property="al:android:url"][content="snssdk1233://user/profile/"]') &&
            pathname.indexOf('/@') == 0 &&
            (pos = 2)
        ) {
            if ((pos = pathname.indexOf('/', pos)) > 0) {
                pathname = pathname.substring(0, pos)
            }
            website = origin + pathname
        }
        return response({
            website: website.replace(/\/$/, '')
        })
    }
})
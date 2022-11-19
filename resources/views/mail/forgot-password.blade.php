<table align="center" width="690" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
       style="font-family:Helvetica,Arial,sans-serif!important">
    <tbody>
    <tr>
        <td height="16"></td>
    </tr>
    <tr>
        <td align="center" width="100%">
            <img src="{{ asset('public/'.$data['site_logo']) }}"
                 alt="{{ $data['site_name'] }}" border="0" width="200" style="display:block">
        </td>
    </tr>
    <tr>
        <td height="16"></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff"
                   style="border:1px solid #dedede;border-radius:3px">
                <tbody>
                <tr>
                    <td align="left" valign="top">
                        <table width="560" align="center" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td height="56"></td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <span style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:22px;font-weight:bold;line-height:1.5">
                                        Hi {{ $data['email'] }},
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                        {{ $data['site_name'] }} has received a request to reset the password for your account.
                                        If you did not request to reset your password, please ignore this email.
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a href="{{ $data['link'] }}"
                                       style="color:#000bff;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:bold;line-height:1.5;text-decoration:none"
                                       target="_blank">
                                        <span style="">
                                            Reset password now
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    <span>If this link doesn't work, copy this URL and paste it directly into your browser.</span>
                                    <br>
                                    <span style="font-style: italic;">{{ $data['link'] }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td height="56"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="24"></td>
    </tr>
    <tr>
        <td align="center">
            <span style="color:#75787d;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:normal;line-height:1.5">
                © {{ date('Y') }} {{ $data['site_name'] }}. All Rights Reserved.
            </span>
        </td>
    </tr>
    <tr>
        <td height="24"></td>
    </tr>
    </tbody>
</table>

<table align="center" width="690" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
       style="font-family:Helvetica,Arial,sans-serif!important">
    <tbody>
    <tr>
        <td height="16"></td>
    </tr>
    <tr>
        <td align="center" width="100%">
            <a href="{{ route('dashboard') }}" target="_blank">
                <img src="{{ asset('public/'.$data['site_logo']) }}"
                     alt="{{ $data['site_name'] }}" border="0" width="200" style="display:block">
            </a>
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
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    {{ $data['name'] }} is interested in partnering up with your brand!
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    They are interested in:<br>
                                    {{ $data['offers'].($data['offers'] && $data['posts'] ? ' AND' : '').$data['posts'] }}
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    You can reach them via email here:<br>
                                    <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    Reminder: Pub Recruiter helps start partnerships using our marketplace and extension.
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    Thank you,<br>
                                    {{ $data['site_name'] }}<br>
                                    +<br>
                                    {{ $data['name'] }}
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

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
                                    <p>I personally want to thank you for joining our exciting and engaging partnership platform, {{ $data['site_name'] }}.
                                        Started in 2020, {{ $data['site_name'] }} was first an agency, then a solution,
                                        then an agency, and then a software solution again.
                                        Just like all things in life and business…being agile is extremely important in order to grow and scale.
                                        So again, thank you for taking the journey with us.</p>
                                    <p>In order to get the most out of your Creator account;
                                        <strong style="font-style:italic;text-decoration:underline;">
                                            we highly recommend placing or editing your Opportunities within your account dashboard
                                        </strong>.</p>
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5;text-align:center;">
                                    <img src="{{ asset('public/assets/images/add-opportunity.png') }}" alt="add opportunity" style="max-width:500px;">
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    <p>Here you can add flat fee placements, sponsorships, and other extra revenue earning
                                        pathways for Brands to see and act on. We made it easy for you and the Brand!</p>
                                    <p>We hope you enjoy our platform and it brings you more revenue for your business
                                        that you worked so hard on. If you have any feedback or suggestions,
                                        feel free to leave them with me directly!</p>
                                </td>
                            </tr>
                            <tr>
                                <td height="24"></td>
                            </tr>
                            <tr>
                                <td style="color:#000000;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:normal;line-height:1.5">
                                    Sincerely,<br>
                                    Todd Weitzman<br>
                                    Todd@PubRecruiter.com
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

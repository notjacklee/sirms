<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:Arial, Helvetica, sans-serif; color:#1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding:32px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 25px rgba(15, 23, 42, 0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#0f172a; padding:24px 32px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <div style="display:flex; align-items:center;">
                                            <img src="{{ asset('images/sirms-logo.png') }}" alt="SIRMS Logo" style="width:48px; height:48px; border-radius:10px; object-fit:cover; margin-right:14px;">
                                            <div style="display:inline-block; vertical-align:middle;">
                                                <div style="font-size:22px; font-weight:700; color:#ffffff;">SIRMS</div>
                                                <div style="font-size:12px; color:#94a3b8;">Security Incident Reporting & Management System</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 32px;">
                            {{ Illuminate\Mail\Markdown::parse($slot) }}
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:24px 32px; background-color:#f8fafc; border-top:1px solid #e2e8f0; text-align:center;">
                            <p style="margin:0; font-size:13px; color:#64748b;">
                                This is an automated email from <strong>SIRMS</strong>.
                            </p>
                            <p style="margin:8px 0 0; font-size:12px; color:#94a3b8;">
                                © {{ date('Y') }} Security Incident Reporting & Management System
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Incident Update</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;">

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                
                <table width="600" style="background: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="text-align: center; padding-bottom: 20px;">
                            <h2 style="color: #2c3e50;">🚨 SIRMS Notification</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td>
                            <p>Hello <strong>{{ $notifiable->name }}</strong>,</p>

                            <p>Your incident status has been updated.</p>

                            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
                                <p><strong>📌 Title:</strong> {{ $incident->title }}</p>
                                <p><strong>⚠️ Status:</strong> 
                                    <span style="color: #007bff; font-weight: bold;">
                                        {{ $statusName }}
                                    </span>
                                </p>
                            </div>

                            <p>Please log in to the system to view more details.</p>

                            <!-- Button -->
                            <div style="text-align: center; margin: 20px 0;">
                                <a href="{{ url('/dashboard') }}" 
                                   style="background: #007bff; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px;">
                                    View Incident
                                </a>
                            </div>

                            <p style="font-size: 12px; color: #888;">
                                Thank you for using SIRMS.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
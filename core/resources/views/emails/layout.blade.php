<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EarnBirr' }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f0fdf4;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">
                    {{-- Logo --}}
                    <tr>
                        <td align="center" style="padding-bottom:30px;">
                            <div style="display:inline-flex;align-items:center;gap:10px;">
                                <div style="width:44px;height:44px;background:linear-gradient(135deg,#10b981,#059669);border-radius:12px;text-align:center;line-height:44px;">
                                    <span style="color:white;font-size:22px;font-weight:bold;">E</span>
                                </div>
                                <span style="font-size:26px;font-weight:800;color:#111827;">EarnBirr</span>
                            </div>
                        </td>
                    </tr>

                    {{-- Card --}}
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
                                {{-- Header --}}
                                <tr>
                                    <td style="background:linear-gradient(135deg,#10b981,#059669);padding:35px 40px;text-align:center;">
                                        <div style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:50%;margin:0 auto 16px;line-height:60px;">
                                            <span style="font-size:28px;">{{ $icon ?? '🔑' }}</span>
                                        </div>
                                        <h1 style="color:#ffffff;font-size:24px;font-weight:700;margin:0;">{{ $heading ?? 'Password Reset' }}</h1>
                                    </td>
                                </tr>

                                {{-- Body --}}
                                <tr>
                                    <td style="padding:40px;">
                                        <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 20px;">
                                            {{ $greeting ?? 'Hello' }},
                                        </p>
                                        <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 30px;">
                                            {{ $message ?? 'We received a request to reset your password. Use the code below to verify your identity:' }}
                                        </p>

                                        {{-- Code Box --}}
                                        @if(isset($code))
                                        <div style="background-color:#f0fdf4;border:2px dashed #10b981;border-radius:12px;padding:20px;text-align:center;margin:0 0 30px;">
                                            <p style="color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:2px;margin:0 0 8px;">Your Verification Code</p>
                                            <p style="color:#10b981;font-size:36px;font-weight:800;letter-spacing:8px;margin:0;font-family:'Courier New',monospace;">{{ $code }}</p>
                                        </div>
                                        @endif

                                        {{-- Button --}}
                                        @if(isset($actionText) && isset($actionUrl))
                                        <div style="text-align:center;margin:0 0 30px;">
                                            <a href="{{ $actionUrl }}" style="display:inline-block;background:linear-gradient(135deg,#10b981,#059669);color:#ffffff;font-size:16px;font-weight:600;text-decoration:none;padding:14px 40px;border-radius:10px;">
                                                {{ $actionText }}
                                            </a>
                                        </div>
                                        @endif

                                        <p style="color:#6b7280;font-size:13px;line-height:1.6;margin:0 0 10px;">
                                            {{ $footer ?? 'If you did not request this, you can safely ignore this email. Your password will remain unchanged.' }}
                                        </p>
                                    </td>
                                </tr>

                                {{-- Footer --}}
                                <tr>
                                    <td style="background-color:#f9fafb;padding:25px 40px;text-align:center;border-top:1px solid #f3f4f6;">
                                        <p style="color:#9ca3af;font-size:12px;margin:0 0 8px;">
                                            This email was sent by EarnBirr
                                        </p>
                                        <p style="color:#9ca3af;font-size:12px;margin:0;">
                                            © {{ date('Y') }} EarnBirr. All rights reserved.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

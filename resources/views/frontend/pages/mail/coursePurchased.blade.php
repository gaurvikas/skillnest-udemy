<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Course Purchase Successful - SkillNest</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>

<body
    style="margin: 0; padding: 0; background-color: #f7f9fa; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;">

    <!-- Outer Wrapper -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
        style="background-color: #f7f9fa; padding: 24px 0;">
        <tr>
            <td align="center" style="padding: 0;">

                <!-- Email Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.09);">

                    <!-- HEADER -->
                    <tr>
                        <td align="center"
                            style="background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%); padding: 50px 30px; text-align: center;">

                            <!-- Success Circle -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="80"
                                style="margin: 0 auto 20px;">
                                <tr>
                                    <td align="center"
                                        style="width: 80px; height: 80px; background: rgba(255,255,255,0.25); border-radius: 50%; font-size: 40px; line-height: 80px; text-align: center;">
                                        ✓
                                    </td>
                                </tr>
                            </table>

                            <!-- Logo -->
                            <div
                                style="font-size: 32px; font-weight: 800; color: #ffffff; letter-spacing: -1px; margin-bottom: 12px;">

                                <a href="{{ route('index') }}">
                                    <img src="{{ asset('logo-light.png') }}" alt="SkillNest" class="h-36"
                                        style="display:block;border:0;">
                                </a>
                            </div>

                            <!-- Title -->
                            <div style="font-size: 24px; font-weight: 700; color: #ffffff; margin-bottom: 6px;">
                                Payment Successful! 🎉
                            </div>

                            <!-- Subtitle -->
                            <div style="font-size: 15px; color: rgba(255,255,255,0.95);">
                                Your course is ready to start
                            </div>

                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding: 36px 32px; background-color: #ffffff;">

                            <!-- Greeting -->
                            <p
                                style="font-size: 24px; font-weight: 700; color: #1c1d1f; margin: 0 0 12px 0; font-family: -apple-system, Arial, sans-serif;">
                                Hi {{ $user_name ?? 'Dinesh kumar' }}! 👋
                            </p>

                            <!-- Message -->
                            <p
                                style="font-size: 15px; line-height: 1.8; color: #6a6f73; margin: 0 0 28px 0; font-family: -apple-system, Arial, sans-serif;">
                                Great news! Your payment was successful and your course is now available in <strong
                                    style="color: #1c1d1f;">My Learning</strong>. Start learning today and take your
                                skills to the next level!
                            </p>

                            <!-- ORDER SUMMARY BOX -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%); border: 2px solid #A435F0; border-radius: 10px; margin: 0 0 28px 0;">
                                <tr>
                                    <td style="padding: 24px;">

                                        <!-- Box Title -->
                                        <p
                                            style="font-size: 16px; font-weight: 700; color: #1c1d1f; margin: 0 0 16px 0; font-family: -apple-system, Arial, sans-serif;">
                                            📋 Order Summary
                                        </p>

                                        <!-- Order Details Table -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                            width="100%">
                                            <tr>
                                                <td
                                                    style="padding: 10px 0; border-bottom: 1px solid rgba(164,53,240,0.15); font-size: 14px; color: #6a6f73; font-family: -apple-system, Arial, sans-serif;">
                                                    Order ID
                                                </td>
                                                <td align="right"
                                                    style="padding: 10px 0; border-bottom: 1px solid rgba(164,53,240,0.15); font-size: 14px; color: #1c1d1f; font-weight: 600; font-family: -apple-system, Arial, sans-serif;">
                                                    #{{ $order_number ?? 'ORD-20260316-0003' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 10px 0; border-bottom: 1px solid rgba(164,53,240,0.15); font-size: 14px; color: #6a6f73; font-family: -apple-system, Arial, sans-serif;">
                                                    Payment Date
                                                </td>
                                                <td align="right"
                                                    style="padding: 10px 0; border-bottom: 1px solid rgba(164,53,240,0.15); font-size: 14px; color: #1c1d1f; font-weight: 600; font-family: -apple-system, Arial, sans-serif;">
                                                    {{ $paid_at ?? 'Mar 16, 2026' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 10px 0; border-bottom: 1px solid rgba(164,53,240,0.15); font-size: 14px; color: #6a6f73; font-family: -apple-system, Arial, sans-serif;">
                                                    Payment Method
                                                </td>
                                                <td align="right"
                                                    style="padding: 10px 0; border-bottom: 1px solid rgba(164,53,240,0.15); font-size: 14px; color: #1c1d1f; font-weight: 600; font-family: -apple-system, Arial, sans-serif;">
                                                    {{ $payment_method ?? 'Online Payment' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding: 14px 0 0 0; border-top: 2px solid rgba(164,53,240,0.3); font-size: 18px; color: #1c1d1f; font-weight: 700; font-family: -apple-system, Arial, sans-serif;">
                                                    Total Paid
                                                </td>
                                                <td align="right"
                                                    style="padding: 14px 0 0 0; border-top: 2px solid rgba(164,53,240,0.3); font-size: 18px; color: #A435F0; font-weight: 700; font-family: -apple-system, Arial, sans-serif;">
                                                    ${{ number_format($total ?? 577, 2) }}
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <!-- Section Title -->
                            <p
                                style="font-size: 18px; font-weight: 700; color: #1c1d1f; margin: 28px 0 16px 0; font-family: -apple-system, Arial, sans-serif;">
                                Your Purchased Course
                            </p>

                            <!-- COURSE CARD -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="border: 2px solid #e9ecef; border-radius: 10px; overflow: hidden; margin: 0 0 18px 0;">
                                <tr>
                                    <td style="padding: 0;">
                                        <!-- Course Thumbnail -->
                                        <img src="https://placehold.co/600x160/A435F0/ffffff?text=Unity+Game+Development+2024"
                                            alt="Course" width="600"
                                            style="display: block; width: 100%; height: auto; max-height: 160px; object-fit: cover; border: 0;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 18px 20px; background-color: #ffffff;">

                                        <!-- Course Title -->
                                        <p
                                            style="font-size: 16px; font-weight: 700; color: #1c1d1f; line-height: 1.4; margin: 0 0 12px 0; font-family: -apple-system, Arial, sans-serif;">
                                            {{ $course_title ?? 'Unity Game Development 2024' }}
                                        </p>

                                        <!-- Course Meta -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #6a6f73; padding-right: 14px; font-family: -apple-system, Arial, sans-serif;">
                                                    👨‍🏫 {{ $instructor_name ?? 'Myrtle Bashirian' }}
                                                </td>
                                                <td
                                                    style="font-size: 12px; color: #6a6f73; padding-right: 14px; font-family: -apple-system, Arial, sans-serif;">
                                                    ⏱️ {{ $duration ?? '0h 16m' }}
                                                </td>
                                                <td
                                                    style="font-size: 12px; color: #6a6f73; font-family: -apple-system, Arial, sans-serif;">
                                                    📹 {{ $lessons ?? '1 Lessons' }}
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="margin: 24px 0;">
                                <tr>
                                    <td align="center" style="padding: 0;">
                                        <a href="{{ route('my-learning.index') }}"
                                            style="display: inline-block; background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%); color: #ffffff; font-size: 16px; font-weight: 700; padding: 16px 42px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 12px rgba(164,53,240,0.3); font-family: -apple-system, Arial, sans-serif;">
                                            🚀 Start Learning Now
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- What You Get -->
                            <p
                                style="font-size: 18px; font-weight: 700; color: #1c1d1f; margin: 28px 0 16px 0; font-family: -apple-system, Arial, sans-serif;">
                                What You Get
                            </p>

                            <!-- Features Grid -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                width="100%" style="margin: 0 0 28px 0;">
                                <tr>
                                    <!-- Feature 1 -->
                                    <td width="48%" style="vertical-align: top; padding-right: 2%;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                            width="100%"
                                            style="background: #f7f9fa; border: 1px solid #e9ecef; border-radius: 8px; margin-bottom: 12px;">
                                            <tr>
                                                <td align="center" style="padding: 18px 14px;">
                                                    <div style="font-size: 28px; margin-bottom: 8px;">🎓</div>
                                                    <div
                                                        style="font-size: 12px; font-weight: 600; color: #1c1d1f; font-family: -apple-system, Arial, sans-serif;">
                                                        Lifetime Access</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <!-- Feature 2 -->
                                    <td width="48%" style="vertical-align: top; padding-left: 2%;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                            width="100%"
                                            style="background: #f7f9fa; border: 1px solid #e9ecef; border-radius: 8px; margin-bottom: 12px;">
                                            <tr>
                                                <td align="center" style="padding: 18px 14px;">
                                                    <div style="font-size: 28px; margin-bottom: 8px;">📱</div>
                                                    <div
                                                        style="font-size: 12px; font-weight: 600; color: #1c1d1f; font-family: -apple-system, Arial, sans-serif;">
                                                        Mobile & Desktop</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Feature 3 -->
                                    <td width="48%" style="vertical-align: top; padding-right: 2%;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                            width="100%"
                                            style="background: #f7f9fa; border: 1px solid #e9ecef; border-radius: 8px;">
                                            <tr>
                                                <td align="center" style="padding: 18px 14px;">
                                                    <div style="font-size: 28px; margin-bottom: 8px;">📜</div>
                                                    <div
                                                        style="font-size: 12px; font-weight: 600; color: #1c1d1f; font-family: -apple-system, Arial, sans-serif;">
                                                        Certificate</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <!-- Feature 4 -->
                                    <td width="48%" style="vertical-align: top; padding-left: 2%;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                            width="100%"
                                            style="background: #f7f9fa; border: 1px solid #e9ecef; border-radius: 8px;">
                                            <tr>
                                                <td align="center" style="padding: 18px 14px;">
                                                    <div style="font-size: 28px; margin-bottom: 8px;">💬</div>
                                                    <div
                                                        style="font-size: 12px; font-weight: 600; color: #1c1d1f; font-family: -apple-system, Arial, sans-serif;">
                                                        Q&A Support</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps Box -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                width="100%"
                                style="background: #faf5ff; border: 2px solid #e9d5ff; border-radius: 10px; margin: 24px 0;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <p
                                            style="font-size: 14px; font-weight: 700; color: #1c1d1f; margin: 0 0 10px 0; font-family: -apple-system, Arial, sans-serif;">
                                            💡 Next Steps
                                        </p>
                                        <p
                                            style="font-size: 13px; color: #6a6f73; line-height: 1.8; margin: 0; font-family: -apple-system, Arial, sans-serif;">
                                            1. Visit <strong style="color: #1c1d1f;">My Learning</strong> to access
                                            your course<br>
                                            2. Download the SkillNest mobile app for learning on-the-go<br>
                                            3. Join our community and connect with fellow learners<br>
                                            4. Complete the course and earn your certificate!
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                width="100%">
                                <tr>
                                    <td style="padding: 24px 0;">
                                        <div style="border-top: 1px solid #e9ecef;"></div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Help Text -->
                            <p
                                style="font-size: 15px; line-height: 1.8; color: #6a6f73; margin: 0 0 24px 0; font-family: -apple-system, Arial, sans-serif;">
                                <strong style="color: #1c1d1f;">Need Help?</strong><br>
                                Visit our <a href="#"
                                    style="color: #A435F0; font-weight: 600; text-decoration: none;">Help Center</a> or
                                email <a href="mailto:support@skillnest.com"
                                    style="color: #A435F0; text-decoration: none;">support@skillnest.com</a>
                            </p>

                            <!-- Divider -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                width="100%">
                                <tr>
                                    <td style="padding: 0 0 24px 0;">
                                        <div style="border-top: 1px solid #e9ecef;"></div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Closing -->
                            <p
                                style="font-size: 15px; line-height: 1.8; color: #6a6f73; margin: 0; font-family: -apple-system, Arial, sans-serif;">
                                Happy learning! 🌟<br>
                                <strong style="color: #1c1d1f;">The SkillNest Team</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="background-color: #1c1d1f; padding: 32px 30px;">

                            <!-- Logo -->

                            <a href="{{ route('index') }}">
                                <img src="{{ config('app.url') }}/logo-light.png" alt="SkillNest" width="140"
                                    style="display:block;border:0;">
                            </a>

                            <!-- Footer Links -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                style="margin: 0 auto 18px;">
                                <tr>
                                    <td style="padding: 0 10px;">
                                        <a href="#"
                                            style="font-size: 12px; color: #9e9ea8; text-decoration: none; font-family: -apple-system, Arial, sans-serif;">My
                                            Learning</a>
                                    </td>
                                    <td style="padding: 0 10px;">
                                        <a href="#"
                                            style="font-size: 12px; color: #9e9ea8; text-decoration: none; font-family: -apple-system, Arial, sans-serif;">Browse</a>
                                    </td>
                                    <td style="padding: 0 10px;">
                                        <a href="#"
                                            style="font-size: 12px; color: #9e9ea8; text-decoration: none; font-family: -apple-system, Arial, sans-serif;">Help</a>
                                    </td>
                                    <td style="padding: 0 10px;">
                                        <a href="#"
                                            style="font-size: 12px; color: #9e9ea8; text-decoration: none; font-family: -apple-system, Arial, sans-serif;">Support</a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Copyright -->
                            <p
                                style="font-size: 11px; color: #6a6f73; line-height: 1.7; margin: 0; font-family: -apple-system, Arial, sans-serif;">
                                © {{ date('Y') }} SkillNest, Inc. All rights reserved.<br>
                                <span style="opacity: 0.65;">
                                    This is a transactional email for your recent purchase.<br>
                                    <a href="#" style="color: #9e9ea8; text-decoration: underline;">View
                                        Invoice</a> | <a href="#"
                                        style="color: #9e9ea8; text-decoration: underline;">Order Details</a>
                                </span>
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

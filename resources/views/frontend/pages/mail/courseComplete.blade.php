<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Course Completed — SkillNest</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background-color: #f7f9fa;
        }

        /* ── HEADER ── */
        .header-td {
            background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%);
            padding: 52px 36px 44px;
            text-align: center;
            position: relative;
        }

        .trophy-wrap {
            width: 88px;
            height: 88px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            line-height: 88px;
            font-size: 42px;
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.15);
        }

        .congrats-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 14px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -1px;
            margin-bottom: 14px;
        }

        .header-title {
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .header-sub {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* ── CONTENT ── */
        .content-td {
            background: #ffffff;
            padding: 40px 36px 32px;
        }

        .greeting {
            font-size: 22px;
            font-weight: 700;
            color: #1c1d1f;
            margin-bottom: 10px;
        }

        .msg {
            font-size: 15px;
            line-height: 1.8;
            color: #6a6f73;
            margin-bottom: 28px;
        }

        /* ── COURSE HIGHLIGHT ── */
        .course-box {
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            border: 2px solid #A435F0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 28px;
        }

        .course-box-header {
            background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%);
            padding: 12px 22px;
        }

        .course-box-header-text {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #ffffff;
        }

        .course-box-body {
            padding: 22px;
        }

        .course-name {
            font-size: 20px;
            font-weight: 700;
            color: #1c1d1f;
            line-height: 1.35;
            margin-bottom: 18px;
        }

        .timeline-table {
            width: 100%;
            border-collapse: collapse;
        }

        .timeline-table td {
            font-size: 13px;
            padding: 9px 0;
            border-bottom: 1px solid rgba(164, 53, 240, 0.15);
        }

        .timeline-table tr:last-child td {
            border-bottom: none;
        }

        .tl-label {
            color: #6a6f73;
            font-weight: 600;
        }

        .tl-value {
            color: #1c1d1f;
            font-weight: 600;
            text-align: right;
        }

        /* ── STATS STRIP ── */
        .stats-strip {
            background: #1c1d1f;
            border-radius: 10px;
            padding: 22px 18px;
            margin-bottom: 28px;
        }

        .stats-strip-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #A435F0;
            text-align: center;
            margin-bottom: 18px;
        }

        .stats-row-table {
            width: 100%;
        }

        .stat-td {
            text-align: center;
            padding: 0 8px;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-td:last-child {
            border-right: none;
        }

        .stat-num {
            font-size: 22px;
            font-weight: 800;
            color: #A435F0;
            margin-bottom: 5px;
        }

        .stat-lbl {
            font-size: 10px;
            color: #9e9ea8;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* ── CTA BUTTONS ── */
        .cta-wrap {
            text-align: center;
            margin-bottom: 28px;
        }

        .cta-primary {
            display: inline-block;
            background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%);
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 800;
            padding: 15px 36px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 12px;
            box-shadow: 0 4px 12px rgba(164, 53, 240, 0.3);
        }

        .cta-secondary {
            display: inline-block;
            background: transparent;
            color: #A435F0 !important;
            font-size: 14px;
            font-weight: 700;
            padding: 13px 36px;
            border-radius: 8px;
            text-decoration: none;
            border: 2px solid #A435F0;
        }

        /* ── REVIEW BOX ── */
        .review-box {
            background: #faf5ff;
            border: 2px solid #e9d5ff;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 28px;
            text-align: center;
        }

        .review-stars {
            font-size: 22px;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .review-title {
            font-size: 15px;
            font-weight: 700;
            color: #1c1d1f;
            margin-bottom: 8px;
        }

        .review-msg {
            font-size: 13px;
            color: #6a6f73;
            line-height: 1.7;
            margin-bottom: 16px;
        }

        .review-btn {
            display: inline-block;
            background: #A435F0;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            padding: 11px 28px;
            border-radius: 6px;
            text-decoration: none;
        }

        /* ── NEXT STEPS ── */
        .next-table td {
            padding: 10px 0;
            vertical-align: top;
        }

        .next-num {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #A435F0, #8710d8);
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
        }

        .next-title {
            font-size: 13px;
            font-weight: 700;
            color: #1c1d1f;
        }

        .next-desc {
            font-size: 12px;
            color: #6a6f73;
            margin-top: 2px;
        }

        .divider {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 24px 0;
        }

        /* ── FOOTER ── */
        .footer-td {
            background: #1c1d1f;
            padding: 32px 30px;
            text-align: center;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 18px;
        }

        .footer-links-table td {
            padding: 0 10px;
        }

        .footer-links-table a {
            font-size: 12px;
            color: #9e9ea8;
            text-decoration: none;
        }

        .footer-links-table a:hover {
            color: #A435F0;
        }

        .copyright {
            font-size: 11px;
            color: #6a6f73;
            line-height: 1.7;
            margin-top: 18px;
        }

        @media only screen and (max-width: 600px) {
            .content-td {
                padding: 28px 18px !important;
            }

            .header-td {
                padding: 36px 18px !important;
            }

            .stat-num {
                font-size: 18px !important;
            }
        }
    </style>
</head>

<body>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f7f9fa; padding:28px 8px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:600px; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.08);">

                    {{-- HEADER --}}
                    <tr>
                        <td class="header-td">
                            <div class="trophy-wrap">🏆</div>
                            <div class="congrats-label">✦ CONGRATULATIONS ✦</div>
                            <div class="logo-text">SkillNest</div>
                            <div class="header-title">"You did it, {{ $user_name }}!"</div>
                            <div class="header-sub">Course successfully completed</div>
                        </td>
                    </tr>

                    {{-- CONTENT --}}
                    <tr>
                        <td class="content-td">
                            <p class="greeting">Hi {{ $user_name }}! 🎓</p>
                            <p class="msg">
                                We're incredibly proud of you. You've put in the hard work and completed your course
                                from start to finish. Your dedication and persistence have paid off!
                            </p>

                            {{-- COURSE HIGHLIGHT --}}
                            <div class="course-box">
                                <div class="course-box-header">
                                    <span class="course-box-header-text">📚 COMPLETED COURSE</span>
                                </div>
                                <div class="course-box-body">
                                    <p class="course-name">{{ $course->title }}</p>
                                    <table class="timeline-table">
                                        <tr>
                                            <td class="tl-label">🗓️ Enrolled On</td>
                                            <td class="tl-value">{{ $enrolled_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="tl-label">✅ Completed On</td>
                                            <td class="tl-value">{{ $completed_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="tl-label">⏳ Time Taken</td>
                                            <td class="tl-value">{{ $days_taken }} days</td>
                                        </tr>
                                        <tr>
                                            <td class="tl-label">👨‍🏫 Instructor</td>
                                            <td class="tl-value">{{ $course->instructor->name ?? '—' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- STATS --}}
                            <div class="stats-strip">
                                <p class="stats-strip-title">YOUR ACHIEVEMENT</p>
                                <table class="stats-row-table">
                                    <tr>
                                        <td class="stat-td">
                                            <div class="stat-num">{{ $total_lessons }}</div>
                                            <div class="stat-lbl">Lessons</div>
                                        </td>
                                        <td class="stat-td">
                                            <div class="stat-num">{{ $total_duration_hours }}h</div>
                                            <div class="stat-lbl">Content</div>
                                        </td>
                                        <td class="stat-td">
                                            <div class="stat-num">100%</div>
                                            <div class="stat-lbl">Progress</div>
                                        </td>
                                        <td class="stat-td">
                                            <div class="stat-num">1</div>
                                            <div class="stat-lbl">Certificate</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            {{-- CTA --}}
                            <div class="cta-wrap">
                                <a href="{{ $certificate_url }}" class="cta-primary">🏅 Download Certificate</a>
                                <br>
                                <a href="{{ $my_learning_url }}" class="cta-secondary">📚 Go to My Learning</a>
                            </div>

                            {{-- REVIEW --}}
                            <div class="review-box">
                                <div class="review-stars">⭐⭐⭐⭐⭐</div>
                                <p class="review-title">Share Your Experience!</p>
                                <p class="review-msg">
                                    Your feedback helps thousands of learners. Did you enjoy
                                    <strong>{{ $course->title }}</strong>?
                                    Leave a quick review!
                                </p>

                                <a href="{{ route('reviews.index', $course->id) }}" class="review-btn">✍️ Write a
                                    Review</a>
                            </div>

                            {{-- NEXT STEPS --}}
                            <p style="font-size:16px; font-weight:700; color:#1c1d1f; margin-bottom:18px;">What's Next?
                            </p>
                            <table class="next-table">
                                <tr>
                                    <td style="width:32px;">
                                        <div class="next-num">1</div>
                                    </td>
                                    <td style="padding-left:14px;">
                                        <div class="next-title">Download your certificate</div>
                                        <div class="next-desc">Share it on LinkedIn to showcase your new skill.</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:32px;">
                                        <div class="next-num">2</div>
                                    </td>
                                    <td style="padding-left:14px;">
                                        <div class="next-title">Leave a review</div>
                                        <div class="next-desc">Help fellow learners by sharing your experience.</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:32px;">
                                        <div class="next-num">3</div>
                                    </td>
                                    <td style="padding-left:14px;">
                                        <div class="next-title">Keep the momentum going</div>
                                        <div class="next-desc">Explore related courses and level up further.</div>
                                    </td>
                                </tr>
                            </table>

                            <hr class="divider">

                            <p class="msg">
                                <strong>Need Help?</strong><br>
                                Visit our <a href="#"
                                    style="color:#A435F0; font-weight:600; text-decoration:none;">Help Center</a>
                                or email <a href="mailto:support@skillnest.com"
                                    style="color:#A435F0; text-decoration:none;">support@skillnest.com</a>
                            </p>

                            <hr class="divider">

                            <p class="msg">With pride, 🌟<br><strong>The SkillNest Team</strong></p>
                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td class="footer-td">
                            <a href="{{ route('index') }}">
                                <img src="{{ asset('logo-light.png') }}" alt="SkillNest" class="h-36"
                                    style="display:block;border:0;">
                            </a>

                            <table class="footer-links-table" cellpadding="0" cellspacing="0"
                                style="margin:0 auto 18px;">
                                <tr>
                                    <td><a href="#">My Learning</a></td>
                                    <td><a href="#">Browse</a></td>
                                    <td><a href="#">Certificate</a></td>
                                    <td><a href="#">Help</a></td>
                                </tr>
                            </table>
                            <p class="copyright">
                                © {{ date('Y') }} SkillNest, Inc. All rights reserved.<br>
                                <span style="opacity:0.65;">You received this because you completed a course on
                                    SkillNest.</span>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>

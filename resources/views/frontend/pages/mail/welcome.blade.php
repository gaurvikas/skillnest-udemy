<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Welcome to SkillNest!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f7f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            background-color: #f7f9fa;
            padding: 32px 16px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        /* ── HEADER ── */
        .header {
            background-color: #1c1d1f;
            padding: 24px 40px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -1px;
        }

        /* ── HERO BANNER ── */
        .hero-banner {
            background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%);
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-greeting {
            font-size: 13px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.9);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.25;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .hero-subtitle {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* ── BODY ── */
        .body-content {
            padding: 40px 40px 32px;
        }

        .welcome-message {
            font-size: 15px;
            color: #2d2f31;
            line-height: 1.8;
            margin-bottom: 32px;
        }

        .welcome-message strong {
            color: #1c1d1f;
            font-weight: 600;
        }

        /* ── FEATURES ── */
        .features-title {
            font-size: 12px;
            font-weight: 700;
            color: #6a6f73;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .features-grid {
            display: table;
            width: 100%;
            border-collapse: separate;
            margin-bottom: 36px;
        }

        .feature-cell {
            display: table-cell;
            width: 50%;
            padding: 0 8px 16px 0;
            vertical-align: top;
        }

        .feature-cell:nth-child(even) {
            padding-right: 0;
            padding-left: 8px;
        }

        .feature-card {
            background: #f7f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px 18px;
        }

        .feature-icon {
            font-size: 28px;
            margin-bottom: 10px;
            display: block;
        }

        .feature-name {
            font-size: 14px;
            font-weight: 700;
            color: #1c1d1f;
            margin-bottom: 6px;
        }

        .feature-desc {
            font-size: 13px;
            color: #6a6f73;
            line-height: 1.6;
        }

        .divider {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 0 0 32px;
        }

        /* ── STATS ── */
        .stats-strip {
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            border: 2px solid #e9d5ff;
            border-radius: 8px;
            padding: 24px 28px;
            margin-bottom: 36px;
            text-align: center;
        }

        .stats-strip-label {
            font-size: 12px;
            color: #A435F0;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .stats-row {
            display: table;
            width: 100%;
        }

        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 0 12px;
            border-right: 1px solid #e9d5ff;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 800;
            color: #A435F0;
            display: block;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 11px;
            color: #6a6f73;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* ── CTA ── */
        .cta-section {
            text-align: center;
            margin-bottom: 36px;
        }

        .cta-text {
            font-size: 15px;
            color: #2d2f31;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #A435F0 0%, #8710d8 100%);
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            padding: 16px 36px;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(164, 53, 240, 0.3);
        }

        .cta-note {
            margin-top: 12px;
            font-size: 12px;
            color: #9e9ea8;
        }

        /* ── CATEGORIES ── */
        .categories-title {
            font-size: 14px;
            font-weight: 700;
            color: #1c1d1f;
            margin-bottom: 14px;
        }

        .pills-wrap {
            line-height: 2.4;
        }

        .pill {
            display: inline-block;
            background: #f7f9fa;
            color: #2d2f31;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            margin: 0 4px 8px 0;
            border: 1px solid #e9ecef;
        }

        /* ── FOOTER ── */
        .footer {
            background-color: #1c1d1f;
            padding: 32px 40px;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
        }

        .footer-links {
            margin-bottom: 20px;
        }

        .footer-links a {
            font-size: 12px;
            color: #9e9ea8;
            text-decoration: none;
            margin-right: 16px;
        }

        .footer-links a:hover {
            color: #A435F0;
        }

        .footer-text {
            font-size: 11px;
            color: #6a6f73;
            line-height: 1.7;
        }

        .footer-text a {
            color: #9e9ea8;
            text-decoration: underline;
        }

        @media only screen and (max-width: 620px) {
            .email-wrapper {
                padding: 0;
            }

            .email-container {
                border-radius: 0;
            }

            .header,
            .hero-banner,
            .body-content,
            .footer {
                padding: 24px 20px;
            }

            .hero-title {
                font-size: 26px;
            }

            .features-grid,
            .stats-row {
                display: block;
            }

            .feature-cell,
            .stat-item {
                display: block;
                width: 100%;
                padding: 0 0 12px 0 !important;
                border: none;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">

            {{-- HEADER --}}
            <div class="header">
                <span class="logo-text">SkillNest</span>
            </div>

            {{-- HERO --}}
            <div class="hero-banner">
                <p class="hero-greeting">🎉 WELCOME ABOARD</p>
                <h1 class="hero-title">Hi {{ $user_name }},<br>Your learning journey starts now</h1>
                <p class="hero-subtitle">
                    You've just joined over 57 million learners worldwide. Whatever you want to learn — we've got a
                    course for that.
                </p>
            </div>

            {{-- BODY --}}
            <div class="body-content">
                <p class="welcome-message">
                    We're thrilled to have you with us! Your account is all set and ready to go.
                    From coding to cooking, photography to finance — <strong>SkillNest has 210,000+ courses</strong>
                    taught
                    by real-world experts waiting for you.
                </p>

                <p class="features-title">WHAT YOU GET WITH SkillNest</p>
                <table class="features-grid">
                    <tr>
                        <td class="feature-cell">
                            <div class="feature-card">
                                <span class="feature-icon">🎓</span>
                                <p class="feature-name">Expert Instructors</p>
                                <p class="feature-desc">Learn from industry professionals with real-world experience.
                                </p>
                            </div>
                        </td>
                        <td class="feature-cell">
                            <div class="feature-card">
                                <span class="feature-icon">📱</span>
                                <p class="feature-name">Learn Anywhere</p>
                                <p class="feature-desc">Access courses on mobile, tablet, or desktop — anytime.</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="feature-cell">
                            <div class="feature-card">
                                <span class="feature-icon">♾️</span>
                                <p class="feature-name">Lifetime Access</p>
                                <p class="feature-desc">Buy once, access forever. Go at your own pace.</p>
                            </div>
                        </td>
                        <td class="feature-cell">
                            <div class="feature-card">
                                <span class="feature-icon">🏆</span>
                                <p class="feature-name">Certificates</p>
                                <p class="feature-desc">Earn shareable certificates to show off your new skills.</p>
                            </div>
                        </td>
                    </tr>
                </table>

                <hr class="divider" />

                <div class="stats-strip">
                    <p class="stats-strip-label">SkillNest by the numbers</p>
                    <table class="stats-row" role="presentation" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="stat-item">
                                <span class="stat-number">
                                    @if ($stats['total_courses'] >= 1000)
                                        {{ number_format($stats['total_courses'] / 1000, 0) }}K+
                                    @else
                                        {{ $stats['total_courses'] }}+
                                    @endif
                                </span>
                                <span class="stat-label">Courses</span>
                            </td>
                            <td class="stat-item">
                                <span class="stat-number">
                                    @if ($stats['total_learners'] >= 1000000)
                                        {{ number_format($stats['total_learners'] / 1000000, 0) }}M+
                                    @elseif($stats['total_learners'] >= 1000)
                                        {{ number_format($stats['total_learners'] / 1000, 0) }}K+
                                    @else
                                        {{ $stats['total_learners'] }}+
                                    @endif
                                </span>
                                <span class="stat-label">Learners</span>
                            </td>
                            <td class="stat-item">
                                <span class="stat-number">
                                    @if ($stats['total_instructors'] >= 1000)
                                        {{ number_format($stats['total_instructors'] / 1000, 0) }}K+
                                    @else
                                        {{ $stats['total_instructors'] }}+
                                    @endif
                                </span>
                                <span class="stat-label">Instructors</span>
                            </td>
                            <td class="stat-item">
                                <span class="stat-number">{{ $categories->count() }}+</span>
                                <span class="stat-label">Categories</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="cta-section">
                    <p class="cta-text">Ready to start? Explore thousands of top-rated courses today.</p>
                    <a href="{{ route('courses') }}" class="cta-button">Start Exploring Courses →</a>
                    <p class="cta-note">No subscription required. Pay only for what you want.</p>
                </div>

                @if ($categories->isNotEmpty())
                    <div style="margin-bottom:36px;">
                        <p class="categories-title">Popular categories to get you started:</p>
                        <div class="pills-wrap">
                            @foreach ($categories as $category)
                                <span class="pill">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- FOOTER --}}
            <div class="footer">
                <div class="footer-logo">SkillNest</div>
                <div class="footer-links">
                    <a href="#">Help Center</a>
                    <a href="#">Terms</a>
                    <a href="#">Privacy Policy</a>
                </div>
                <p class="footer-text">
                    © {{ date('Y') }} SkillNest, Inc. All rights reserved.<br>
                    You're receiving this because you created an account on SkillNest.<br>
                    <a href="#">Unsubscribe</a> from marketing emails.
                </p>
            </div>

        </div>
    </div>
</body>

</html>

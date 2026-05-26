<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('category_course')->delete();
        DB::table('courses')->delete();

        // ─── Helpers ─────────────────────────────────────────────────────────
        $levels   = ['beginner', 'intermediate', 'advanced', 'all_levels'];
        $statuses = ['published', 'published', 'published', 'draft']; // 75 % published

        // ─── 50 Courses ──────────────────────────────────────────────────────
        $courses = [

            // ── Web Development ──────────────────────────────────────────────
            [
                'title'          => 'The Complete HTML & CSS Bootcamp 2025',
                'description'    => 'Master HTML5 and CSS3 from scratch. Build stunning, responsive websites using Flexbox, Grid, and modern CSS techniques. Includes 15+ real-world projects.',
                'original_price' => 3499,
                'price'          => 499,
                'level'          => 'beginner',
                'duration' => 1320,
                'published_at'   => Carbon::parse('2024-01-15'),
            ],
            [
                'title'          => 'JavaScript: Zero to Expert (2025 Edition)',
                'description'    => 'The most complete JavaScript course on the internet. Learn modern JS from the very beginning all the way to advanced concepts like async/await, closures, and OOP.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'beginner',
                'duration' => 4140,
                'published_at'   => Carbon::parse('2024-02-10'),
            ],
            [
                'title'          => 'React – The Complete Guide (incl. Redux & Hooks)',
                'description'    => 'Dive in and learn React from scratch! Learn Reactjs, Hooks, Redux, React Router, Next.js, Best Practices and way more with this complete React course.',
                'original_price' => 3999,
                'price'          => 699,
                'level'          => 'intermediate',
                'duration' => 2880,
                'published_at'   => Carbon::parse('2024-03-05'),
            ],
            [
                'title'          => 'Vue 3 – The Complete Guide (incl. Router & Vuex)',
                'description'    => 'Vue.js is an awesome JavaScript framework! Master Vue 3 from the ground up and build amazing real-world web apps.',
                'original_price' => 3799,
                'price'          => 649,
                'level'          => 'intermediate',
                'duration' => 1860,
                'published_at'   => Carbon::parse('2024-03-20'),
            ],
            [
                'title'          => 'Laravel 11 – Build Real-World Apps with PHP',
                'description'    => 'Learn Laravel 11 by building 5 full-stack applications. Covers Eloquent ORM, Blade templating, REST APIs, authentication, queues and more.',
                'original_price' => 4499,
                'price'          => 849,
                'level'          => 'intermediate',
                'duration' => 2400,
                'published_at'   => Carbon::parse('2024-04-01'),
            ],
            [
                'title'          => 'Node.js, Express, MongoDB & More: The Complete Bootcamp',
                'description'    => 'Master Node.js by building a complete, full-featured RESTful API and a server-side rendered website, both from scratch.',
                'original_price' => 3999,
                'price'          => 749,
                'level'          => 'intermediate',
                'duration' => 2520,
                'published_at'   => Carbon::parse('2024-04-18'),
            ],
            [
                'title'          => 'Next.js 14 & React – The Complete Guide',
                'description'    => 'Use Next.js 14 and React to build full-stack, SEO-friendly web applications. Server components, server actions, data caching and more.',
                'original_price' => 3999,
                'price'          => 699,
                'level'          => 'intermediate',
                'duration' => 2100,
                'published_at'   => Carbon::parse('2024-05-02'),
            ],
            [
                'title'          => 'TypeScript Masterclass – The Complete TypeScript Course',
                'description'    => 'Everything you need to know about TypeScript. Generics, decorators, advanced types, real-world projects and integration with React.',
                'original_price' => 3499,
                'price'          => 599,
                'level'          => 'intermediate',
                'duration' => 1680,
                'published_at'   => Carbon::parse('2024-05-15'),
            ],
            [
                'title'          => 'Tailwind CSS 3 – From Scratch to Production',
                'description'    => 'Master utility-first CSS with Tailwind 3. Build responsive UIs, custom components and design systems faster than ever.',
                'original_price' => 2999,
                'price'          => 499,
                'level'          => 'beginner',
                'duration' => 1080,
                'published_at'   => Carbon::parse('2024-06-01'),
            ],
            [
                'title'          => 'GraphQL with React: The Complete Developers Guide',
                'description'    => 'Learn GraphQL and Apollo Client to build powerful, data-driven React apps. Replace REST with a flexible query language.',
                'original_price' => 3799,
                'price'          => 649,
                'level'          => 'advanced',
                'duration' => 1560,
                'published_at'   => Carbon::parse('2024-06-20'),
            ],

            // ── Mobile Development ───────────────────────────────────────────
            [
                'title'          => 'Flutter & Dart – The Complete App Development Bootcamp',
                'description'    => 'Build beautiful, fast and native quality apps with Flutter. The only course you need to learn how to develop iOS and Android apps.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'beginner',
                'duration' => 2040,
                'published_at'   => Carbon::parse('2024-02-20'),
            ],
            [
                'title'          => 'Android Development with Kotlin – Beginner to Advanced',
                'description'    => 'Learn Android development from scratch using Kotlin. Build 20+ apps with Jetpack Compose, Room, Retrofit, ViewModel and MVVM architecture.',
                'original_price' => 4499,
                'price'          => 849,
                'level'          => 'beginner',
                'duration' => 3120,
                'published_at'   => Carbon::parse('2024-03-10'),
            ],
            [
                'title'          => 'iOS 17 & Swift 5 – The Complete iOS App Development Bootcamp',
                'description'    => 'Join a live online classroom and learn SwiftUI, UIKit, Core Data, Networking and more to become a professional iOS developer.',
                'original_price' => 4999,
                'price'          => 899,
                'level'          => 'beginner',
                'duration' => 3300,
                'published_at'   => Carbon::parse('2024-04-05'),
            ],
            [
                'title'          => 'React Native – The Practical Guide',
                'description'    => 'Use React Native and your React knowledge to build native iOS and Android apps – incl. Redux, Hooks, Navigation and more.',
                'original_price' => 3999,
                'price'          => 749,
                'level'          => 'intermediate',
                'duration' => 2280,
                'published_at'   => Carbon::parse('2024-05-25'),
            ],
            [
                'title'          => 'Jetpack Compose for Android – Modern UI Development',
                'description'    => 'Master Android\'s modern declarative UI toolkit. Build pixel-perfect UIs with state management, animations and Material 3.',
                'original_price' => 3499,
                'price'          => 599,
                'level'          => 'intermediate',
                'duration' => 1440,
                'published_at'   => Carbon::parse('2024-07-01'),
            ],

            // ── Data Science & Machine Learning ──────────────────────────────
            [
                'title'          => 'Python for Data Science and Machine Learning Bootcamp',
                'description'    => 'Learn how to use NumPy, Pandas, Seaborn, Matplotlib, Plotly, Scikit-Learn, Machine Learning, Tensorflow and more.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'intermediate',
                'duration' => 1500,
                'published_at'   => Carbon::parse('2024-01-25'),
            ],
            [
                'title'          => 'Machine Learning A–Z: AI, Python & R + ChatGPT Bonus',
                'description'    => 'Learn to create Machine Learning algorithms in Python and R. Complete guide with Data Pre-Processing, Regression, Classification, Clustering and more.',
                'original_price' => 4499,
                'price'          => 849,
                'level'          => 'all_levels',
                'duration' => 2640,
                'published_at'   => Carbon::parse('2024-02-05'),
            ],
            [
                'title'          => 'Deep Learning Specialisation with TensorFlow & Keras',
                'description'    => 'Master neural networks, CNNs, RNNs, LSTMs, transformers and NLP. Build real-world AI projects from scratch.',
                'original_price' => 4999,
                'price'          => 999,
                'level'          => 'advanced',
                'duration' => 3480,
                'published_at'   => Carbon::parse('2024-03-15'),
            ],
            [
                'title'          => 'Data Analysis with Python & Pandas – Complete Course',
                'description'    => 'Learn data wrangling, cleaning, analysis and visualisation with Python. Work on real datasets and build a portfolio of projects.',
                'original_price' => 3499,
                'price'          => 599,
                'level'          => 'beginner',
                'duration' => 1200,
                'published_at'   => Carbon::parse('2024-04-22'),
            ],
            [
                'title'          => 'SQL & Database Design – Complete Bootcamp 2025',
                'description'    => 'Master SQL from beginner to advanced. Learn MySQL, PostgreSQL, query optimisation, stored procedures and database design patterns.',
                'original_price' => 3799,
                'price'          => 649,
                'level'          => 'beginner',
                'duration' => 1260,
                'published_at'   => Carbon::parse('2024-05-10'),
            ],
            [
                'title'          => 'Natural Language Processing with Python',
                'description'    => 'Build NLP pipelines using NLTK, spaCy, HuggingFace Transformers and OpenAI APIs. Sentiment analysis, chatbots, summarisation and more.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'advanced',
                'duration' => 1920,
                'published_at'   => Carbon::parse('2024-06-12'),
            ],
            [
                'title'          => 'Power BI – Business Intelligence for Beginners',
                'description'    => 'Transform your data into beautiful, interactive dashboards. Learn DAX, Power Query and data modelling with real business datasets.',
                'original_price' => 2999,
                'price'          => 499,
                'level'          => 'beginner',
                'duration' => 960,
                'published_at'   => Carbon::parse('2024-07-08'),
            ],

            // ── Cloud & DevOps ────────────────────────────────────────────────
            [
                'title'          => 'AWS Certified Solutions Architect – Associate 2025',
                'description'    => 'Pass the AWS SAA-C03 exam with confidence. Covers EC2, S3, RDS, VPC, Lambda, IAM, CloudFormation and all exam domains.',
                'original_price' => 4999,
                'price'          => 999,
                'level'          => 'intermediate',
                'duration' => 1620,
                'published_at'   => Carbon::parse('2024-01-30'),
            ],
            [
                'title'          => 'Docker & Kubernetes: The Complete Practical Guide',
                'description'    => 'Learn Docker from scratch to advanced. Containers, images, networks, volumes, Docker Compose and Kubernetes cluster deployment.',
                'original_price' => 4499,
                'price'          => 849,
                'level'          => 'intermediate',
                'duration' => 1380,
                'published_at'   => Carbon::parse('2024-02-28'),
            ],
            [
                'title'          => 'Terraform on AWS – Infrastructure as Code Masterclass',
                'description'    => 'Provision and manage AWS infrastructure with Terraform. Modules, state management, remote backends and CI/CD integration.',
                'original_price' => 4299,
                'price'          => 749,
                'level'          => 'advanced',
                'duration' => 1140,
                'published_at'   => Carbon::parse('2024-03-25'),
            ],
            [
                'title'          => 'CI/CD with GitHub Actions – DevOps for Developers',
                'description'    => 'Automate your deployments with GitHub Actions. Build pipelines, run tests, deploy to AWS and Docker registries.',
                'original_price' => 3499,
                'price'          => 599,
                'level'          => 'intermediate',
                'duration' => 900,
                'published_at'   => Carbon::parse('2024-04-30'),
            ],
            [
                'title'          => 'Linux Command Line & Shell Scripting Bible',
                'description'    => 'Master the Linux command line, Bash scripting, cron jobs, process management and server administration.',
                'original_price' => 3299,
                'price'          => 549,
                'level'          => 'beginner',
                'duration' => 1200,
                'published_at'   => Carbon::parse('2024-05-20'),
            ],
            [
                'title'          => 'Kubernetes for Absolute Beginners – Hands-on',
                'description'    => 'Learn Kubernetes from scratch. Pods, deployments, services, config maps, Helm charts and production-grade cluster management.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'beginner',
                'duration' => 1320,
                'published_at'   => Carbon::parse('2024-06-25'),
            ],
            [
                'title'          => 'Google Cloud Professional Cloud Architect – Exam Prep',
                'description'    => 'Prepare for and pass the GCP Professional Cloud Architect exam. Covers GKE, BigQuery, Cloud Run, IAM, networking and security.',
                'original_price' => 4999,
                'price'          => 949,
                'level'          => 'advanced',
                'duration' => 1800,
                'published_at'   => Carbon::parse('2024-07-15'),
            ],

            // ── Cyber Security ────────────────────────────────────────────────
            [
                'title'          => 'The Complete Ethical Hacking Course – Beginner to Advanced',
                'description'    => 'Become an ethical hacker. Learn network hacking, gain access to any Wi-Fi network, hack servers and bypass firewalls.',
                'original_price' => 4999,
                'price'          => 999,
                'level'          => 'all_levels',
                'duration' => 2700,
                'published_at'   => Carbon::parse('2024-02-15'),
            ],
            [
                'title'          => 'CompTIA Security+ (SY0-701) Complete Course & Practice Exam',
                'description'    => 'Pass the CompTIA Security+ exam on your first try. Covers threats, cryptography, identity management, risk management and compliance.',
                'original_price' => 4499,
                'price'          => 849,
                'level'          => 'intermediate',
                'duration' => 1680,
                'published_at'   => Carbon::parse('2024-03-08'),
            ],
            [
                'title'          => 'Web Application Penetration Testing – OWASP Top 10',
                'description'    => 'Hands-on web pen testing. SQL Injection, XSS, CSRF, broken authentication and more using Burp Suite and OWASP methodology.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'intermediate',
                'duration' => 1320,
                'published_at'   => Carbon::parse('2024-04-10'),
            ],

            // ── Design ────────────────────────────────────────────────────────
            [
                'title'          => 'UI/UX Design Bootcamp – Figma, Prototyping & Research',
                'description'    => 'Become a UX designer from scratch. Learn user research, wireframing, prototyping and creating stunning UIs in Figma.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'beginner',
                'duration' => 2160,
                'published_at'   => Carbon::parse('2024-01-20'),
            ],
            [
                'title'          => 'Adobe Photoshop CC – The Complete Beginners Guide 2025',
                'description'    => 'Learn Photoshop CC from scratch. Photo retouching, manipulation, graphic design and creating stunning digital art.',
                'original_price' => 3299,
                'price'          => 549,
                'level'          => 'beginner',
                'duration' => 1020,
                'published_at'   => Carbon::parse('2024-02-25'),
            ],
            [
                'title'          => 'Adobe Illustrator CC – Advanced Training for Designers',
                'description'    => 'Master vector graphics, logo design, typography and complex illustrations in Adobe Illustrator CC.',
                'original_price' => 3499,
                'price'          => 599,
                'level'          => 'intermediate',
                'duration' => 1140,
                'published_at'   => Carbon::parse('2024-04-15'),
            ],
            [
                'title'          => 'Motion Graphics & Video Editing with After Effects',
                'description'    => 'Create stunning motion graphics, visual effects and animations with Adobe After Effects. No prior experience needed.',
                'original_price' => 3999,
                'price'          => 749,
                'level'          => 'all_levels',
                'duration' => 1500,
                'published_at'   => Carbon::parse('2024-06-05'),
            ],
            [
                'title'          => 'Canva Masterclass – Graphic Design for Non-Designers',
                'description'    => 'Create beautiful social media posts, presentations, logos and marketing materials with Canva. No design experience needed.',
                'original_price' => 1999,
                'price'          => 299,
                'level'          => 'beginner',
                'duration' => 600,
                'published_at'   => Carbon::parse('2024-07-20'),
            ],

            // ── Business & Finance ────────────────────────────────────────────
            [
                'title'          => 'Digital Marketing Masterclass – 23 Courses in 1',
                'description'    => 'Become a digital marketing expert. SEO, social media, email marketing, Google Ads, Facebook Ads, content marketing and more.',
                'original_price' => 4999,
                'price'          => 999,
                'level'          => 'all_levels',
                'duration' => 1380,
                'published_at'   => Carbon::parse('2024-01-10'),
            ],
            [
                'title'          => 'Stock Market Investing for Beginners – Crash Course',
                'description'    => 'Learn how the stock market works, how to analyse stocks, build a portfolio and invest wisely with minimal risk.',
                'original_price' => 2999,
                'price'          => 499,
                'level'          => 'beginner',
                'duration' => 720,
                'published_at'   => Carbon::parse('2024-03-01'),
            ],
            [
                'title'          => 'The Complete Financial Analyst Course 2025',
                'description'    => 'Accounting, financial statements, financial modelling in Excel, valuation, stocks and investment banking.',
                'original_price' => 4499,
                'price'          => 849,
                'level'          => 'all_levels',
                'duration' => 1200,
                'published_at'   => Carbon::parse('2024-05-05'),
            ],
            [
                'title'          => 'Search Engine Optimisation (SEO) 2025 – Complete Course',
                'description'    => 'Rank #1 on Google. Learn keyword research, on-page SEO, link building, technical SEO and local SEO with real case studies.',
                'original_price' => 3799,
                'price'          => 649,
                'level'          => 'all_levels',
                'duration' => 840,
                'published_at'   => Carbon::parse('2024-06-18'),
            ],
            [
                'title'          => 'Entrepreneurship & Startup Launch Masterclass',
                'description'    => 'Turn your idea into a real business. Lean startup methodology, product-market fit, fundraising, growth hacking and scaling.',
                'original_price' => 3999,
                'price'          => 749,
                'level'          => 'all_levels',
                'duration' => 1080,
                'published_at'   => Carbon::parse('2024-07-10'),
            ],

            // ── More Web Development ──────────────────────────────────────────
            [
                'title'          => 'Python Bootcamp 2025: Zero to Hero in Python',
                'description'    => 'Learn Python like a professional. Start from the basics and go all the way to creating your own applications and games.',
                'original_price' => 3999,
                'price'          => 699,
                'level'          => 'beginner',
                'duration' => 1320,
                'published_at'   => Carbon::parse('2024-01-05'),
            ],
            [
                'title'          => 'Django 4 – Full Stack Web Development with Python',
                'description'    => 'Build and deploy real-world web applications with Django 4. ORM, class-based views, REST APIs, authentication and deployment.',
                'original_price' => 4299,
                'price'          => 799,
                'level'          => 'intermediate',
                'duration' => 1920,
                'published_at'   => Carbon::parse('2024-02-02'),
            ],
            [
                'title'          => 'Spring Boot 3 & Microservices – Enterprise Java 2025',
                'description'    => 'Build production-ready microservices with Spring Boot 3, Spring Cloud, Docker, Kubernetes and event-driven architecture.',
                'original_price' => 4999,
                'price'          => 949,
                'level'          => 'advanced',
                'duration' => 2160,
                'published_at'   => Carbon::parse('2024-03-18'),
            ],
            [
                'title'          => 'The Complete Sass & SCSS Course: From Beginner to Advanced',
                'description'    => 'Master Sass and SCSS to write maintainable, modular CSS. Variables, mixins, functions, inheritance and real-world projects.',
                'original_price' => 2499,
                'price'          => 399,
                'level'          => 'beginner',
                'duration' => 600,
                'published_at'   => Carbon::parse('2024-04-28'),
            ],
            [
                'title'          => 'Redis: The Complete Developer\'s Guide',
                'description'    => 'Learn Redis from scratch. Caching, pub/sub, streams, Lua scripting, and integrating Redis with Node.js and Python apps.',
                'original_price' => 3499,
                'price'          => 599,
                'level'          => 'intermediate',
                'duration' => 1020,
                'published_at'   => Carbon::parse('2024-05-28'),
            ],
            [
                'title'          => 'WebSockets & Real-Time Apps with Socket.io & Node',
                'description'    => 'Build real-time chat apps, live dashboards and multiplayer games using WebSockets, Socket.io and Node.js.',
                'original_price' => 3299,
                'price'          => 549,
                'level'          => 'intermediate',
                'duration' => 840,
                'published_at'   => Carbon::parse('2024-06-10'),
            ],
            [
                'title'          => 'Microservices with Node.js & React – The Complete Guide',
                'description'    => 'Build a massive, multi-service app in the cloud. Kubernetes, Docker, CI/CD, TypeScript and the latest microservices patterns.',
                'original_price' => 5499,
                'price'          => 1099,
                'level'          => 'advanced',
                'duration' => 3240,
                'published_at'   => Carbon::parse('2024-07-05'),
            ],
            [
                'title'          => 'WordPress for Beginners: Create a Website Step by Step',
                'description'    => 'Build professional websites with WordPress. Themes, plugins, WooCommerce, Elementor, SEO and website maintenance.',
                'original_price' => 1999,
                'price'          => 349,
                'level'          => 'beginner',
                'duration' => 540,
                'published_at'   => Carbon::parse('2024-07-28'),
            ],
        ];

        $catIds = DB::table('categories')->pluck('id')->toArray();

      
        $catCount = count($catIds);

        $rows = [];
        foreach ($courses as $index => $course) {
            $status = $statuses[array_rand($statuses)];
            $rows[] = [
                'instructor_id' => rand(1, 10),
                'title'         => $course['title'],
                'slug'          => Str::slug($course['title']),
                'description'   => $course['description'],
                'original_price' => $course['original_price'],
                'price'         => $course['price'],
                'level'         => $course['level'],
                'status'        => $status,
                'duration'      => $course['duration'],
                'published_at'  => $status === 'published' ? $course['published_at'] : null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        DB::table('courses')->insert($rows);

        $this->command->info('✅ 50 courses seeded successfully.');
    }
}

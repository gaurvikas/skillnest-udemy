<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('category_course')->delete();
        DB::table('categories')->delete();

        // ─── 10 Parent Categories ────────────────────────────────────────────
        $parents = [
            ['name' => 'Web Development',       'slug' => 'web-development',       'description' => 'Front-end, back-end and full-stack web development.',         'status' => 1, 'icon' => 'fa-code',           'parent_id' => null],
            ['name' => 'Mobile Development',    'slug' => 'mobile-development',    'description' => 'iOS, Android and cross-platform mobile app development.',      'status' => 1, 'icon' => 'fa-mobile-alt',     'parent_id' => null],
            ['name' => 'Data Science',          'slug' => 'data-science',          'description' => 'Data analysis, machine learning and artificial intelligence.', 'status' => 1, 'icon' => 'fa-chart-bar',      'parent_id' => null],
            ['name' => 'Cloud & DevOps',        'slug' => 'cloud-devops',          'description' => 'AWS, Azure, Docker, Kubernetes and CI/CD pipelines.',          'status' => 1, 'icon' => 'fa-cloud',           'parent_id' => null],
            ['name' => 'Cyber Security',        'slug' => 'cyber-security',        'description' => 'Ethical hacking, penetration testing and network security.',   'status' => 1, 'icon' => 'fa-shield-alt',     'parent_id' => null],
            ['name' => 'Design',                'slug' => 'design',                'description' => 'UI/UX, graphic design, video editing and motion graphics.',    'status' => 1, 'icon' => 'fa-paint-brush',    'parent_id' => null],
            ['name' => 'Business & Finance',    'slug' => 'business-finance',      'description' => 'Entrepreneurship, investing, accounting and marketing.',       'status' => 1, 'icon' => 'fa-briefcase',      'parent_id' => null],
            ['name' => 'Programming Languages', 'slug' => 'programming-languages', 'description' => 'Python, Java, C++, Go, Rust and more.',                        'status' => 1, 'icon' => 'fa-terminal',       'parent_id' => null],
            ['name' => 'Database',              'slug' => 'database',              'description' => 'SQL, NoSQL, database design and administration.',              'status' => 1, 'icon' => 'fa-database',       'parent_id' => null],
            ['name' => 'Personal Development',  'slug' => 'personal-development',  'description' => 'Productivity, leadership, communication and soft skills.',     'status' => 1, 'icon' => 'fa-user-graduate',  'parent_id' => null],
        ];

        $parentRows = array_map(fn($r) => array_merge($r, ['created_at' => now(), 'updated_at' => now()]), $parents);
        DB::table('categories')->insert($parentRows);

        // Parent IDs slug se fetch karo
        $p = DB::table('categories')->whereNull('parent_id')->pluck('id', 'slug');

        // ─── Subcategories (har parent ke 3–4) ──────────────────────────────
        $children = [

            // 1. Web Development — 4 subcategories
            ['name' => 'Frontend Development',    'slug' => 'frontend-development',    'description' => 'HTML, CSS, JavaScript, React, Vue and modern frameworks.',     'status' => 1, 'icon' => 'fa-laptop-code',    'parent_id' => $p['web-development']],
            ['name' => 'Backend Development',     'slug' => 'backend-development',     'description' => 'PHP, Laravel, Node.js, Django and server-side programming.',   'status' => 1, 'icon' => 'fa-server',         'parent_id' => $p['web-development']],
            ['name' => 'Full Stack Development',  'slug' => 'full-stack-development',  'description' => 'End-to-end web application development.',                      'status' => 1, 'icon' => 'fa-layer-group',    'parent_id' => $p['web-development']],
            ['name' => 'Web Performance & SEO',   'slug' => 'web-performance-seo',     'description' => 'Page speed, Core Web Vitals and search engine optimisation.',   'status' => 1, 'icon' => 'fa-tachometer-alt', 'parent_id' => $p['web-development']],

            // 2. Mobile Development — 3 subcategories
            ['name' => 'Android Development',     'slug' => 'android-development',     'description' => 'Native Android apps with Kotlin and Java.',                    'status' => 1, 'icon' => 'fa-android',        'parent_id' => $p['mobile-development']],
            ['name' => 'iOS Development',         'slug' => 'ios-development',         'description' => 'Swift and SwiftUI for iPhone and iPad apps.',                  'status' => 1, 'icon' => 'fa-apple',          'parent_id' => $p['mobile-development']],
            ['name' => 'Flutter & React Native',  'slug' => 'flutter-react-native',    'description' => 'Cross-platform mobile apps with a single codebase.',           'status' => 1, 'icon' => 'fa-mobile',         'parent_id' => $p['mobile-development']],

            // 3. Data Science — 4 subcategories
            ['name' => 'Machine Learning',        'slug' => 'machine-learning',        'description' => 'Supervised, unsupervised and reinforcement learning.',         'status' => 1, 'icon' => 'fa-brain',          'parent_id' => $p['data-science']],
            ['name' => 'Deep Learning & AI',      'slug' => 'deep-learning-ai',        'description' => 'Neural networks, TensorFlow, PyTorch and NLP.',               'status' => 1, 'icon' => 'fa-robot',          'parent_id' => $p['data-science']],
            ['name' => 'Data Analysis',           'slug' => 'data-analysis',           'description' => 'Python, Pandas, NumPy, SQL and data visualisation.',           'status' => 1, 'icon' => 'fa-table',          'parent_id' => $p['data-science']],
            ['name' => 'Business Intelligence',   'slug' => 'business-intelligence',   'description' => 'Power BI, Tableau, dashboards and reporting.',                 'status' => 1, 'icon' => 'fa-chart-pie',      'parent_id' => $p['data-science']],

            // 4. Cloud & DevOps — 4 subcategories
            ['name' => 'Amazon Web Services',     'slug' => 'amazon-web-services',     'description' => 'AWS cloud services from beginner to architect level.',         'status' => 1, 'icon' => 'fa-aws',            'parent_id' => $p['cloud-devops']],
            ['name' => 'Docker & Kubernetes',     'slug' => 'docker-kubernetes',       'description' => 'Containerisation, orchestration and microservices.',           'status' => 1, 'icon' => 'fa-docker',         'parent_id' => $p['cloud-devops']],
            ['name' => 'CI/CD & Automation',      'slug' => 'ci-cd-automation',        'description' => 'GitHub Actions, Jenkins, Terraform and infrastructure code.',  'status' => 1, 'icon' => 'fa-cogs',           'parent_id' => $p['cloud-devops']],
            ['name' => 'Linux & Shell Scripting', 'slug' => 'linux-shell-scripting',   'description' => 'Linux command line, Bash scripting and server administration.', 'status' => 1, 'icon' => 'fa-terminal',       'parent_id' => $p['cloud-devops']],

            // 5. Cyber Security — 3 subcategories
            ['name' => 'Ethical Hacking',         'slug' => 'ethical-hacking',         'description' => 'Penetration testing, exploits and bug bounty hunting.',        'status' => 1, 'icon' => 'fa-user-secret',    'parent_id' => $p['cyber-security']],
            ['name' => 'Network Security',        'slug' => 'network-security',        'description' => 'Firewalls, VPNs, intrusion detection and secure networking.',   'status' => 1, 'icon' => 'fa-network-wired',  'parent_id' => $p['cyber-security']],
            ['name' => 'Application Security',    'slug' => 'application-security',    'description' => 'OWASP Top 10, secure coding and web app vulnerability testing.', 'status' => 1, 'icon' => 'fa-lock',          'parent_id' => $p['cyber-security']],

            // 6. Design — 4 subcategories
            ['name' => 'UI/UX Design',            'slug' => 'ui-ux-design',            'description' => 'Figma, wireframing, prototyping and user research.',           'status' => 1, 'icon' => 'fa-pen-nib',        'parent_id' => $p['design']],
            ['name' => 'Graphic Design',          'slug' => 'graphic-design',          'description' => 'Photoshop, Illustrator, logo design and brand identity.',      'status' => 1, 'icon' => 'fa-vector-square',  'parent_id' => $p['design']],
            ['name' => 'Video Editing',           'slug' => 'video-editing',           'description' => 'Premiere Pro, Final Cut Pro and professional video production.', 'status' => 1, 'icon' => 'fa-film',          'parent_id' => $p['design']],
            ['name' => 'Motion Graphics',         'slug' => 'motion-graphics',         'description' => 'After Effects, animations and visual effects.',                'status' => 1, 'icon' => 'fa-magic',          'parent_id' => $p['design']],

            // 7. Business & Finance — 4 subcategories
            ['name' => 'Digital Marketing',       'slug' => 'digital-marketing',       'description' => 'SEO, social media, Google Ads and content marketing.',         'status' => 1, 'icon' => 'fa-bullhorn',       'parent_id' => $p['business-finance']],
            ['name' => 'Investing & Trading',     'slug' => 'investing-trading',       'description' => 'Stock market, crypto, forex and financial planning.',          'status' => 1, 'icon' => 'fa-chart-line',     'parent_id' => $p['business-finance']],
            ['name' => 'Entrepreneurship',        'slug' => 'entrepreneurship',        'description' => 'Startup launch, business planning and growth strategies.',     'status' => 1, 'icon' => 'fa-rocket',         'parent_id' => $p['business-finance']],
            ['name' => 'Accounting & Finance',    'slug' => 'accounting-finance',      'description' => 'Financial analysis, Excel modelling and accounting basics.',   'status' => 1, 'icon' => 'fa-calculator',     'parent_id' => $p['business-finance']],

            // 8. Programming Languages — 3 subcategories
            ['name' => 'Python',                  'slug' => 'python',                  'description' => 'Python from basics to advanced scripting and automation.',      'status' => 1, 'icon' => 'fa-python',         'parent_id' => $p['programming-languages']],
            ['name' => 'Java & Kotlin',           'slug' => 'java-kotlin',             'description' => 'Java fundamentals, Spring Boot and Kotlin for modern development.', 'status' => 1, 'icon' => 'fa-java',         'parent_id' => $p['programming-languages']],
            ['name' => 'C, C++ & Rust',           'slug' => 'c-cpp-rust',              'description' => 'Systems programming, memory management and performance.',      'status' => 1, 'icon' => 'fa-microchip',      'parent_id' => $p['programming-languages']],

            // 9. Database — 3 subcategories
            ['name' => 'SQL & Relational DB',     'slug' => 'sql-relational-db',       'description' => 'MySQL, PostgreSQL, query optimisation and schema design.',     'status' => 1, 'icon' => 'fa-table',          'parent_id' => $p['database']],
            ['name' => 'NoSQL Databases',         'slug' => 'nosql-databases',         'description' => 'MongoDB, Redis, Firebase and document-based databases.',       'status' => 1, 'icon' => 'fa-cubes',          'parent_id' => $p['database']],
            ['name' => 'Database Administration', 'slug' => 'database-administration', 'description' => 'Backup, replication, performance tuning and DB management.',   'status' => 1, 'icon' => 'fa-hdd',            'parent_id' => $p['database']],

            // 10. Personal Development — 3 subcategories
            ['name' => 'Productivity & Time Mgmt', 'slug' => 'productivity-time-management', 'description' => 'Time management, focus techniques and workflow optimisation.', 'status' => 1, 'icon' => 'fa-clock',         'parent_id' => $p['personal-development']],
            ['name' => 'Leadership & Management', 'slug' => 'leadership-management',   'description' => 'Team leadership, decision making and management skills.',      'status' => 1, 'icon' => 'fa-users',          'parent_id' => $p['personal-development']],
            ['name' => 'Communication Skills',    'slug' => 'communication-skills',    'description' => 'Public speaking, writing and professional communication.',     'status' => 1, 'icon' => 'fa-comments',       'parent_id' => $p['personal-development']],
        ];

        $childRows = array_map(fn($c) => array_merge($c, ['created_at' => now(), 'updated_at' => now()]), $children);
        DB::table('categories')->insert($childRows);

        $this->command->info('✅ ' . (count($parents) + count($children)) . ' categories seeded (10 parent + ' . count($children) . ' subcategories).');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CareerPath;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@career.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Student',
            'email' => 'student@career.com',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'department' => 'Science & Tech',
        ]);

        // 2. Seed Career Paths (15 Careers)
        $careers = [
            [
                'code' => 'AI',
                'name' => 'AI Engineer',
                'description' => 'Designs and builds artificial intelligence models, integrates AI capabilities into software applications, and optimizes intelligence-driven workflows.',
                'salary_range' => '$110,000 - $180,000',
                'demand_status' => 'Very High',
                'skills' => ['Deep Learning', 'PyTorch/TensorFlow', 'Neural Networks', 'NLP', 'Computer Vision'],
                'certifications' => ['Google Cloud Professional ML Engineer', 'Microsoft Certified: Azure AI Engineer Associate', 'AWS Certified Machine Learning'],
                'projects' => ['Visual Object Detection System', 'Automated Medical Image Classifier', 'Autonomous Drone Navigation Agent'],
                'roadmap' => [
                    'Phase 1: Advanced mathematics, calculus, linear algebra, and Python programming.',
                    'Phase 2: Master neural network architectures (CNNs, RNNs, Transformers).',
                    'Phase 3: Gain hands-on experience with deep learning frameworks (PyTorch/TensorFlow).',
                    'Phase 4: Build portfolio projects and learn cloud AI model deployment (AWS SageMaker/Vertex AI).'
                ],
                'swot' => [
                    'strengths' => ['Extremely high compensation', 'At the cutting edge of industry innovation', 'High intellectual stimulation'],
                    'weaknesses' => ['Requires heavy academic/theoretical foundation', 'Rapidly changing tooling landscape', 'Computationally expensive debugging'],
                    'opportunities' => ['Lead AI transformation across enterprise businesses', 'Develop proprietary intellectual property', 'High entrepreneurial potential'],
                    'threats' => ['Saturation of entry-level engineers', 'GPU availability and infrastructural cost limitations']
                ]
            ],
            [
                'code' => 'GenAI',
                'name' => 'Generative AI Specialist',
                'description' => 'Focuses on building and leveraging Large Language Models (LLMs), prompt engineering, retrieval-augmented generation (RAG), and agentic workflows.',
                'salary_range' => '$120,000 - $195,000',
                'demand_status' => 'Extreme',
                'skills' => ['LLM Fine-Tuning', 'Prompt Engineering', 'LangChain/LlamaIndex', 'Vector Databases (Pinecone/Chroma)', 'RAG Pipelines'],
                'certifications' => ['DeepLearning.AI Generative AI Developer Certificate', 'AWS Certified AI Practitioner', 'NVIDIA Generative AI Certification'],
                'projects' => ['Agentic Enterprise Customer Service Bot', 'Semantic Search Engine over PDF Repositories', 'Auto-code Generation & Debugging Agent'],
                'roadmap' => [
                    'Phase 1: Strong core in Python and API integration (OpenAI API, HuggingFace).',
                    'Phase 2: Understand vector spaces, embeddings, and RAG architectural patterns.',
                    'Phase 3: Master orchestration frameworks (LangChain, LangGraph, AutoGen).',
                    'Phase 4: Learn model fine-tuning (LoRA, QLoRA) and guardrailing techniques.'
                ],
                'swot' => [
                    'strengths' => ['Highest immediate industry demand', 'Rapid prototyping and deployment cycles', 'Transformative productivity impacts'],
                    'weaknesses' => ['Heavy reliance on commercial API providers', 'Prone to hallucinations and output unpredictability', 'High API cost management complexity'],
                    'opportunities' => ['Automate knowledge workflows in legal, finance, and medicine', 'Build niche AI-agent startups'],
                    'threats' => ['Rapid commoditization of basic prompt engineering skills', 'Strict government copyright and data compliance laws']
                ]
            ],
            [
                'code' => 'ML',
                'name' => 'Machine Learning Engineer',
                'description' => 'Bridges the gap between data science and software engineering, building pipelines to train, evaluate, deploy, and monitor predictive models.',
                'salary_range' => '$105,000 - $170,000',
                'demand_status' => 'Very High',
                'skills' => ['Supervised & Unsupervised Learning', 'Scikit-Learn', 'Feature Engineering', 'Model Deployment (MLOps)', 'Pandas & NumPy'],
                'certifications' => ['AWS Certified Machine Learning - Specialty', 'Google Cloud Professional ML Engineer', 'TensorFlow Developer Certificate'],
                'projects' => ['E-commerce Recommendation System', 'Real-time Credit Card Fraud Detection', 'Predictive Maintenance System for Factories'],
                'roadmap' => [
                    'Phase 1: Core statistics, probability, regression models, and data manipulation.',
                    'Phase 2: Master classical ML algorithms (Random Forests, Gradient Boosting, SVMs).',
                    'Phase 3: Learn features engineering, data scaling, and ML model evaluation metrics.',
                    'Phase 4: Study MLOps pipelines (MLflow, Kubeflow) and containerized deployment (Docker).'
                ],
                'swot' => [
                    'strengths' => ['Highly structured workflows and analytical rigor', 'Robust scientific backing', 'Stable industry relevance'],
                    'weaknesses' => ['Clean data acquisition bottlenecks', 'Model drift and continuous maintenance overhead'],
                    'opportunities' => ['Incorporate prediction systems in healthcare diagnostics, weather, and finance', 'Transition to MLOps architecture'],
                    'threats' => ['Automated ML (AutoML) tools eating into basic model tuning work']
                ]
            ],
            [
                'code' => 'Cloud',
                'name' => 'Cloud Solutions Architect',
                'description' => 'Designs, builds, and manages scalable, secure, and resilient cloud infrastructures (AWS, Azure, GCP) to support enterprise workloads.',
                'salary_range' => '$115,000 - $175,000',
                'demand_status' => 'High',
                'skills' => ['AWS/Azure/GCP Services', 'Network Security', 'Infrastructure as Code (IaC)', 'High Availability Design', 'Cloud Migration'],
                'certifications' => ['AWS Certified Solutions Architect - Professional', 'Google Cloud Certified Professional Cloud Architect', 'Microsoft Certified: Azure Solutions Architect Expert'],
                'projects' => ['Multi-region High Availability Infrastructure', 'Legacy App Migration to AWS Cloud', 'Serverless API Platform'],
                'roadmap' => [
                    'Phase 1: Basic networking, virtualization, Linux administration, and bash scripting.',
                    'Phase 2: Master core cloud services (compute, storage, databases, IAM, VPCs).',
                    'Phase 3: Learn Infrastructure as Code (Terraform or CloudFormation) and configuration management.',
                    'Phase 4: Study cloud design patterns (reliability, scalability, cost-optimization, security).'
                ],
                'swot' => [
                    'strengths' => ['Essential for modern enterprise architectures', 'Highly valued consulting roles', 'Clear certification pathways'],
                    'weaknesses' => ['High financial penalty for architectural misconfigurations', 'Complex billing and cost monitoring systems'],
                    'opportunities' => ['Accelerate legacy-to-cloud transition in traditional industries', 'Optimize hybrid cloud systems'],
                    'threats' => ['Lock-in to a single vendor ecosystem limiting broader marketability']
                ]
            ],
            [
                'code' => 'DevOps',
                'name' => 'DevOps Engineer',
                'description' => 'Automates software development pipelines, orchestrates containerized infrastructures, and fosters collaboration between dev and ops teams to speed up releases.',
                'salary_range' => '$100,000 - $165,000',
                'demand_status' => 'Very High',
                'skills' => ['CI/CD Pipelines (GitHub Actions/Jenkins)', 'Docker & Kubernetes', 'Terraform', 'Linux & Bash Scripting', 'Monitoring (Prometheus/Grafana)'],
                'certifications' => ['Certified Kubernetes Administrator (CKA)', 'AWS Certified DevOps Engineer - Professional', 'HashiCorp Certified: Terraform Associate'],
                'projects' => ['Automated CI/CD Git GitOps Pipeline', 'Kubernetes Cluster Provisioning & Autoscale', 'Log Centralization & Metrics Alert Dashboard'],
                'roadmap' => [
                    'Phase 1: Deep dive into Linux commands, shell scripting, and Git workflows.',
                    'Phase 2: Master containerization (Docker) and basic CI/CD orchestration.',
                    'Phase 3: Study container orchestration (Kubernetes) and Infrastructure as Code (Terraform).',
                    'Phase 4: Learn site reliability engineering (SRE) concepts, logging, and alerting systems.'
                ],
                'swot' => [
                    'strengths' => ['Vital link in modern agile development teams', 'Saves organizations enormous operational time', 'High career stability'],
                    'weaknesses' => ['On-call support duties and stressful production outages', 'Requires knowing a wide array of ever-evolving tools'],
                    'opportunities' => ['Standardize DevSecOps practices', 'Automate multi-tenant SaaS environments'],
                    'threats' => ['No-code CI/CD platforms reducing standard pipeline configuration tasks']
                ]
            ],
            [
                'code' => 'Python',
                'name' => 'Python Developer',
                'description' => 'Writes clean, readable backend code, automates complex scripting processes, and implements data pipelines using the versatile Python language.',
                'salary_range' => '$85,000 - $135,000',
                'demand_status' => 'High',
                'skills' => ['Python (Django/Flask/FastAPI)', 'Asynchronous Programming', 'SQL & ORMs (SQLAlchemy)', 'RESTful APIs', 'Web Scraping'],
                'certifications' => ['Certified Associate in Python Programming (PCAP)', 'Certified Professional in Python Programming (PCPP)', 'AWS Developer Associate'],
                'projects' => ['Scalable REST API with FastAPI & Redis', 'High-throughput Web Scraper and Parser', 'Automated Office Workflows Automation Suite'],
                'roadmap' => [
                    'Phase 1: Learn Python basics, data structures, OOP concepts, and clean coding PEP-8 standards.',
                    'Phase 2: Master SQL databases, database integrations, and writing APIs using Flask or FastAPI.',
                    'Phase 3: Study advanced patterns (generators, decorators, multithreading, concurrency).',
                    'Phase 4: Learn testing practices (PyTest) and basic deployment methods.'
                ],
                'swot' => [
                    'strengths' => ['Highly readable, intuitive language syntax', 'Massive ecosystem of libraries', 'Flexible career pivots (Data, Web, AI)'],
                    'weaknesses' => ['Execution speed compared to compiled languages (C++, Go)', 'Mobile application ecosystem limitations'],
                    'opportunities' => ['Rapid prototyping for startups', 'Transition into Data Engineering or AI/ML fields'],
                    'threats' => ['Low barrier to entry leading to high junior-level job market competition']
                ]
            ],
            [
                'code' => 'Full Stack',
                'name' => 'Full Stack Developer',
                'description' => 'Handles both the user-facing interface and server-side logic, integrating front-end screens with back-end databases and APIs.',
                'salary_range' => '$90,000 - $150,000',
                'demand_status' => 'High',
                'skills' => ['React/Vue/Angular', 'Node.js/Laravel', 'Database Design (SQL & NoSQL)', 'REST/GraphQL APIs', 'Vite & Frontend Tooling'],
                'certifications' => ['Meta Full Stack Developer Professional Certificate', 'AWS Certified Developer - Associate', 'MongoDB Certified Developer'],
                'projects' => ['E-commerce SPA Web App with Checkout', 'Real-time Collaborative Task Board', 'Social Network Dashboard with Live Messaging'],
                'roadmap' => [
                    'Phase 1: HTML, CSS, JavaScript basics, DOM manipulation, and responsive CSS.',
                    'Phase 2: Master a backend environment (NodeJS/Express or Laravel) and relational databases.',
                    'Phase 3: Adopt a modern frontend framework (React or Vue) and state management.',
                    'Phase 4: Study security basics (OAuth, JWT), WebSockets, and cloud deployment.'
                ],
                'swot' => [
                    'strengths' => ['Versatile skill set, highly independent contributor', 'High startup appeal', 'Complete product owner mentality'],
                    'weaknesses' => ['Hard to master both fields fully ("Jack of all trades, master of none")', 'High context-switching fatigue'],
                    'opportunities' => ['Launch SaaS products alone', 'Pivotal tech lead in multidisciplinary teams'],
                    'threats' => ['AI code assistants making full stack code assembly easier, raising junior performance bars']
                ]
            ],
            [
                'code' => 'Frontend',
                'name' => 'Frontend Developer',
                'description' => 'Builds beautiful, responsive, and interactive user interfaces using modern web frameworks, focusing on web performance and user experience.',
                'salary_range' => '$80,000 - $130,000',
                'demand_status' => 'Medium-High',
                'skills' => ['HTML5 & Semantic markup', 'CSS (Flexbox/Grid/Sass)', 'React/Vue.js', 'JavaScript (ES6+)', 'Web Performance & SEO'],
                'certifications' => ['Meta Frontend Developer Professional Certificate', 'W3Cx Frontend Developer Professional Certificate', 'Google UX Design Certificate'],
                'projects' => ['Responsive Interactive Dashboard', 'Music Streaming Web Player Client', 'Portfolio Hub with Micro-animations'],
                'roadmap' => [
                    'Phase 1: Master semantic HTML, modern responsive CSS layouts, and basic JS operations.',
                    'Phase 2: Learn modern JS features, asynchronous fetch requests, and NPM build tools.',
                    'Phase 3: Deep dive into a framework (React, Vue, or Angular) along with routing and global state.',
                    'Phase 4: Optimize bundle sizes, implement accessibility (WCAG), and polish micro-interactions.'
                ],
                'swot' => [
                    'strengths' => ['Visual, rewarding output loops', 'Direct impact on user satisfaction', 'Thriving, supportive developer community'],
                    'weaknesses' => ['Browser compatibility headaches', 'High dependency on unstable frontend packages and build systems'],
                    'opportunities' => ['Specialize in WebGL, 3D graphics, or interactive design systems', 'Accessibility consulting'],
                    'threats' => ['No-code web builders taking over simple site layouts']
                ]
            ],
            [
                'code' => 'Backend',
                'name' => 'Backend Developer',
                'description' => 'Designs core database schemas, constructs scalable server-side business logic, secures application APIs, and handles data integrations.',
                'salary_range' => '$88,000 - $140,000',
                'demand_status' => 'High',
                'skills' => ['Node.js/PHP/Java/Go', 'RESTful & GraphQL API Design', 'Database Optimization & SQL', 'Caching (Redis/Memcached)', 'System Architecture'],
                'certifications' => ['Oracle Certified Associate (Java)', 'AWS Certified Developer - Associate', 'Spring Professional Certification'],
                'projects' => ['High-Performance E-commerce Billing Engine', 'Automated Notification & Email Queue Microservice', 'Multitenant File Storage API'],
                'roadmap' => [
                    'Phase 1: Learn programming fundamentals (OOP or functional) and basic SQL.',
                    'Phase 2: Study server frameworks, HTTP protocol, middleware, routing, and error handling.',
                    'Phase 3: Deepen database knowledge (indexing, transactions, migrations) and security principles.',
                    'Phase 4: Design distributed architectures, use message queues (RabbitMQ/Kafka), and master caching.'
                ],
                'swot' => [
                    'strengths' => ['Focuses on engineering core logic rather than design aesthetics', 'Very structured and logical', 'High stability'],
                    'weaknesses' => ['Invisible achievements (difficult to present visually to non-tech managers)', 'Complex server-side bug tracing'],
                    'opportunities' => ['Scale system throughput and write high-performance APIs for mobile apps', 'Transition to Cloud/System Design'],
                    'threats' => ['Backend-as-a-Service (BaaS) platforms reducing custom CRUD backend logic needs']
                ]
            ],
            [
                'code' => 'Cyber Security',
                'name' => 'Cybersecurity Analyst',
                'description' => 'Protects organizational networks, servers, and applications by auditing security postures, pentesting vulnerabilities, and responding to incidents.',
                'salary_range' => '$95,000 - $160,000',
                'demand_status' => 'Very High',
                'skills' => ['Penetration Testing', 'Network Auditing (Wireshark)', 'OWASP Top 10 Security', 'Incident Response', 'Cryptography & Firewalls'],
                'certifications' => ['CompTIA Security+', 'Certified Ethical Hacker (CEH)', 'Certified Information Systems Security Professional (CISSP)'],
                'projects' => ['Vulnerability Assessment of Web Applications', 'Secure VPN Server with Multi-Factor Auth', 'Intrusion Detection & Firewall Rule Suite'],
                'roadmap' => [
                    'Phase 1: Grasp networking, protocols (TCP/IP), OS fundamentals (Linux/Windows), and scripting basics.',
                    'Phase 2: Study network security policies, system hardening, and encryption techniques.',
                    'Phase 3: Practice web app penetration testing and ethical hacking in controlled labs (TryHackMe/HackTheBox).',
                    'Phase 4: Master risk assessment, compliance frameworks (ISO 27001), and security information management (SIEM).'
                ],
                'swot' => [
                    'strengths' => ['Critical enterprise priority (recession-proof)', 'High sense of purpose', 'Extremely high compensation for experts'],
                    'weaknesses' => ['High burnout rate due to high-stakes, 24/7 incident monitoring', 'Zero margin for error'],
                    'opportunities' => ['Consult on data privacy laws (GDPR/CCPA)', 'Secure blockchain or AI infrastructures'],
                    'threats' => ['Highly sophisticated AI-driven hacking tactics require constant, exhausting upskilling']
                ]
            ],
            [
                'code' => 'Data Analyst',
                'name' => 'Data Analyst',
                'description' => 'Extracts insights from structured and unstructured data, designs dashboards, and delivers reports to help executives make data-driven decisions.',
                'salary_range' => '$70,000 - $115,000',
                'demand_status' => 'High',
                'skills' => ['SQL Queries', 'Excel & BI Tools (Tableau/PowerBI)', 'Data Wrangling (Python/R)', 'Statistical Analysis', 'Data Storytelling'],
                'certifications' => ['Google Data Analytics Professional Certificate', 'Microsoft Certified: Power BI Data Analyst Associate', 'Tableau Desktop Desktop Specialist'],
                'projects' => ['Company Sales Analysis Interactive Dashboard', 'Customer Retention & Churn Report', 'Web Traffic Conversion Funnel Study'],
                'roadmap' => [
                    'Phase 1: Master advanced Microsoft Excel (Pivot tables, VLOOKUP) and fundamental statistics.',
                    'Phase 2: Learn complex SQL queries (Joins, Window functions, aggregations).',
                    'Phase 3: Pick up a business intelligence tool (Power BI or Tableau) to create interactive dashboard layouts.',
                    'Phase 4: Learn data cleaning in Python (Pandas) and practice writing executive business summaries.'
                ],
                'swot' => [
                    'strengths' => ['Highly visible role, close to executive decisions', 'Direct business impact', 'Relatively quick to enter the field'],
                    'weaknesses' => ['Clean data acquisition is time-consuming', 'Often tasked with boring, ad-hoc spreadsheet reporting'],
                    'opportunities' => ['Direct career transition into Data Science or Product Management', 'Optimize operational efficiencies'],
                    'threats' => ['Automatic dashboarding tools simplifying basic reporting workflows']
                ]
            ],
            [
                'code' => 'Business Analyst',
                'name' => 'Business Analyst',
                'description' => 'Bridges the gap between IT team capabilities and business goals, defining clear software requirements and analyzing process feasibility.',
                'salary_range' => '$75,000 - $120,000',
                'demand_status' => 'High',
                'skills' => ['Requirements Gathering', 'Process Mapping (BPMN)', 'Agile/Scrum Frameworks', 'Jira & Confluence', 'Stakeholder Management'],
                'certifications' => ['Certified Business Analysis Professional (CBAP)', 'PMI Professional in Business Analysis (PMI-PBA)', 'Certified Scrum Product Owner (CSPO)'],
                'projects' => ['System Requirements Specification (SRS) for Mobile App', 'Enterprise ERP System Upgrade Feasibility Study', 'Operational Cost Optimization Audit'],
                'roadmap' => [
                    'Phase 1: Learn business logic, project management lifecycles, and software development methodologies (Agile).',
                    'Phase 2: Study modeling tools (BPMN, UML, wireframing) and documentation standards (User stories).',
                    'Phase 3: Learn requirement validation, gap analysis, and standard project management software (Jira).',
                    'Phase 4: Polish stakeholder negotiation, conflict management, and presentation skills.'
                ],
                'swot' => [
                    'strengths' => ['Minimal coding requirements', 'Great for natural organizers and communicators', 'Clear path to management'],
                    'weaknesses' => ['Stuck between demands of engineering and non-tech clients', 'Can be document-heavy'],
                    'opportunities' => ['Lead digital transformations', 'Transition into Product Ownership or Project Management'],
                    'threats' => ['Automation of standard requirement mapping and workflow audits']
                ]
            ],
            [
                'code' => 'Software Tester',
                'name' => 'QA & Software Tester',
                'description' => 'Verifies software quality by writing test plans, automating regression tests, and finding bugs before applications go to production.',
                'salary_range' => '$65,000 - $110,000',
                'demand_status' => 'Medium-High',
                'skills' => ['Manual Testing Methodologies', 'Selenium/Cypress/Playwright', 'Test Case Writing', 'API Testing (Postman)', 'Bug Tracking (Jira)'],
                'certifications' => ['ISTQB Certified Tester Foundation Level (CTFL)', 'Certified Software Quality Analyst (CSQA)', 'Cypress Certified Developer'],
                'projects' => ['Automated Test Suite for E-Commerce Checkout', 'Comprehensive REST API Integration Test Suite', 'Cross-browser Accessibility Audit Report'],
                'roadmap' => [
                    'Phase 1: Understand software development lifecycle (SDLC) and manual testing techniques.',
                    'Phase 2: Master bug logging templates, test case plans, and Postman API checks.',
                    'Phase 3: Learn basic scripting (JS or Python) and test automation libraries (Cypress/Playwright).',
                    'Phase 4: Integrate tests into CI/CD pipelines and learn load/stress testing tools (JMeter).'
                ],
                'swot' => [
                    'strengths' => ['Lower technical barrier to entry initially', 'Deeply valued for ensuring system stability', 'Satisfying analytical problem hunting'],
                    'weaknesses' => ['Can feel repetitive', 'Sometimes viewed as a secondary concern by rushed developer teams'],
                    'opportunities' => ['Transition to Test Automation Architect or Site Reliability Engineering (SRE)'],
                    'threats' => ['AI code assistants scanning and writing standard unit tests automatically']
                ]
            ],
            [
                'code' => 'UI/UX',
                'name' => 'UI/UX Designer',
                'description' => 'Shapes product interfaces by conducting user research, wireframing workflows, and creating high-fidelity interactive visual designs.',
                'salary_range' => '$75,000 - $125,000',
                'demand_status' => 'High',
                'skills' => ['Figma/Adobe XD', 'Wireframing & Prototyping', 'User Research & Personas', 'Interaction Design', 'Typography & Color Theory'],
                'certifications' => ['Google UX Design Professional Certificate', 'Interaction Design Foundation (IxDF) Certifications', 'Nielsen Norman Group UX Certification'],
                'projects' => ['Complete Redesign of Mobile Banking Application', 'Interactive Design System for SaaS platform', 'UX Case Study on Cart Abandonment Reduction'],
                'roadmap' => [
                    'Phase 1: Understand design principles, color theory, spacing, typography, and grid systems.',
                    'Phase 2: Master UI design software (Figma), wireframing speed, and component structures.',
                    'Phase 3: Learn user research methodologies, interviews, card sorting, and user testing.',
                    'Phase 4: Design complete high-fidelity prototypes and learn UI developers handoff guidelines.'
                ],
                'swot' => [
                    'strengths' => ['Highly creative and human-centered', 'Directly impacts the beauty of products', 'Strong UI/UX design portfolios attract immediate work'],
                    'weaknesses' => ['Subjective feedback loops from clients and directors', 'Constantly learning Figma updates and interactive plugins'],
                    'opportunities' => ['Pivotal role in starting up new app designs', 'Specializing in voice, AR/VR, or automotive interfaces'],
                    'threats' => ['AI-driven design generators assembling simple UI layouts automatically']
                ]
            ],
            [
                'code' => 'DBA',
                'name' => 'Database Administrator',
                'description' => 'Maintains relational and non-relational database management systems, ensuring high performance, transaction safety, backups, and security policies.',
                'salary_range' => '$90,000 - $145,000',
                'demand_status' => 'Medium-High',
                'skills' => ['SQL Query Tuning', 'Database Security & Auditing', 'Replication & Backups', 'MySQL/PostgreSQL/MongoDB', 'Stored Procedures'],
                'certifications' => ['Oracle Database Administration Certified Professional', 'Microsoft Certified: Azure Database Administrator Associate', 'PostgreSQL Associate Certification'],
                'projects' => ['Multi-Master Database Replication Configuration', 'Database Migration with Zero Downtime', 'Performance Diagnostic & Query Optimization Audit'],
                'roadmap' => [
                    'Phase 1: Strong relational database theory, database normalization, and SQL fundamentals.',
                    'Phase 2: Master server administration, database installation, configurations, and users permission rules.',
                    'Phase 3: Learn database backups, recovery, clustering, high availability, and indexing patterns.',
                    'Phase 4: Study NoSQL systems, scaling techniques (sharding), and database engine configurations.'
                ],
                'swot' => [
                    'strengths' => ['Crucial guardian of the most important asset: data', 'High professional authority', 'Excellent job security'],
                    'weaknesses' => ['Extremely high pressure during data recovery operations', 'Can be routine-heavy'],
                    'opportunities' => ['Design distributed cloud databases', 'Pivoting into Data Engineering fields'],
                    'threats' => ['Fully managed cloud databases (AWS RDS, Aurora) taking over basic DBA administration tasks']
                ]
            ]
        ];

        foreach ($careers as $c) {
            CareerPath::create($c);
        }

        // 3. Seed Questions & Options (45 Psychology-based questions)
        // Grouped into 9 categories (5 questions each)
        // The scoring weights sum to career codes
        $questionsData = [
            // WORK STYLE (5 questions)
            [
                'category' => 'Work Style',
                'question_text' => 'A critical deadline is looming, and your part of the project is blocked by another team member. What is your reaction?',
                'options' => [
                    ['text' => 'Set up automated tests to ensure everything done so far works, and document the blockers clearly.', 'weights' => ['Software Tester' => 5, 'Business Analyst' => 3]],
                    ['text' => 'Dive into their repository or tasks to see if you can solve the issue yourself or write a quick patch.', 'weights' => ['Backend' => 5, 'Python' => 4, 'Full Stack' => 3]],
                    ['text' => 'Design an alternative client-side mockup or mock data to keep refining the user interfaces.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Organize a quick meeting to coordinate roles, unblock bottlenecks, or adjust cloud deploy plans.', 'weights' => ['DevOps' => 5, 'Cloud' => 4, 'Business Analyst' => 4]],
                ]
            ],
            [
                'category' => 'Work Style',
                'question_text' => 'Which working environment makes you feel most productive and comfortable?',
                'options' => [
                    ['text' => 'A highly structured setting with clear guidelines, checklists, and quality assurance logs.', 'weights' => ['Software Tester' => 5, 'DBA' => 4, 'Business Analyst' => 3]],
                    ['text' => 'An experimental environment where I can train models and parse data with open-ended results.', 'weights' => ['AI' => 5, 'ML' => 5, 'Python' => 4]],
                    ['text' => 'A visual space focused on user journeys, aesthetic details, and interactive animations.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'A fast-paced environment centered around server infrastructure, deployments, and live pipelines.', 'weights' => ['DevOps' => 5, 'Cloud' => 4, 'Backend' => 3]],
                ]
            ],
            [
                'category' => 'Work Style',
                'question_text' => 'When working in a team on a new feature development, which role do you naturally fall into?',
                'options' => [
                    ['text' => 'The one organizing tasks, documenting rules, and explaining requirements to stakeholders.', 'weights' => ['Business Analyst' => 5, 'Cyber Security' => 3]],
                    ['text' => 'The developer implementing the core algorithms, APIs, and data transactions behind the scenes.', 'weights' => ['Backend' => 5, 'Full Stack' => 4, 'Python' => 3]],
                    ['text' => 'The designer sketching out wireframes and making the front-end components look perfect.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'The administrator automating the building process, checking vulnerabilities, and setting servers.', 'weights' => ['DevOps' => 5, 'Cloud' => 4, 'Cyber Security' => 4]],
                ]
            ],
            [
                'category' => 'Work Style',
                'question_text' => 'How do you handle having multiple tasks and projects assigned to you at the same time?',
                'options' => [
                    ['text' => 'Log everything in a tracker, prioritize by business impact, and define strict task specs.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 4]],
                    ['text' => 'Write script scripts to automate repetitive parts of my tasks so I can focus on core coding.', 'weights' => ['Python' => 5, 'ML' => 4, 'Backend' => 3]],
                    ['text' => 'Work closely with front-end developers, resolving visual design conflicts slice by slice.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Create a virtual testing environment to ensure new setups don\'t disrupt the live server configurations.', 'weights' => ['Cloud' => 5, 'DevOps' => 4, 'DBA' => 4]],
                ]
            ],
            [
                'category' => 'Work Style',
                'question_text' => 'What is your preferred approach when a client suddenly changes the requirements mid-project?',
                'options' => [
                    ['text' => 'Perform a gap analysis, update the requirements, and align the developer timeline.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 3]],
                    ['text' => 'Adapt the backend database schemas and modular code logic to accommodate the changes.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Iterate immediately on the user flows and UI interactive components to fit the new vision.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Ensure the deployment infrastructure can scale dynamically to support the new features.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                ]
            ],

            // PROBLEM SOLVING (5 questions)
            [
                'category' => 'Problem Solving',
                'question_text' => 'A user reports that the application is running very slowly, but there are no error messages. How do you start?',
                'options' => [
                    ['text' => 'Examine database query logs and execute EXPLAIN statements to optimize indexes.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                    ['text' => 'Review the user analytics dashboard and run diagnostic scripts to profile script runtimes.', 'weights' => ['Data Analyst' => 5, 'Python' => 4, 'ML' => 3]],
                    ['text' => 'Check browser loading speeds, rendering lag, and optimize image bundle sizes.', 'weights' => ['Frontend' => 5, 'UI/UX' => 3]],
                    ['text' => 'Check server CPU/RAM usage logs, cloud load balancers, and network traffic routes.', 'weights' => ['Cloud' => 5, 'DevOps' => 5, 'Cyber Security' => 3]],
                ]
            ],
            [
                'category' => 'Problem Solving',
                'question_text' => 'You notice that a system is outputting unexpected results under rare conditions. What do you do?',
                'options' => [
                    ['text' => 'Create boundary test cases, execute automated regression suites, and isolate the exact inputs.', 'weights' => ['Software Tester' => 5, 'Data Analyst' => 3]],
                    ['text' => 'Trace the mathematical calculations, analyze the statistical variables, or tune model parameters.', 'weights' => ['ML' => 5, 'AI' => 5, 'Python' => 3]],
                    ['text' => 'Conduct user session reviews to see how users interact with the fields that cause this error.', 'weights' => ['UI/UX' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Audit security log events and server access logs to rule out unauthorized manipulation.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 3]],
                ]
            ],
            [
                'category' => 'Problem Solving',
                'question_text' => 'You are tasked with securing a legacy application that has multiple vulnerable dependencies. How do you proceed?',
                'options' => [
                    ['text' => 'Conduct static application security testing (SAST) and apply dependency patches immediately.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 4]],
                    ['text' => 'Rewrite critical backend modules to remove deprecated libraries and secure API endpoints.', 'weights' => ['Backend' => 5, 'Full Stack' => 4]],
                    ['text' => 'Write a comprehensive unit test suite to verify no functionalities break while upgrading libraries.', 'weights' => ['Software Tester' => 5, 'Python' => 3]],
                    ['text' => 'Consult with team leads and client managers to document risks and schedule migration phases.', 'weights' => ['Business Analyst' => 5, 'Cloud' => 3]],
                ]
            ],
            [
                'category' => 'Problem Solving',
                'question_text' => 'An essential third-party API service that your app relies on has crashed. What is your immediate solution?',
                'options' => [
                    ['text' => 'Document the outage, communicate with client support, and prepare clear user guides.', 'weights' => ['Business Analyst' => 5, 'UI/UX' => 3]],
                    ['text' => 'Implement a backend queue fallback mechanism or switch database logs to offline cache mode.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Provide a beautiful user alert/modal and disable dependent buttons gracefully in the UI.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Configure cloud load balancer rules to redirect requests to a standby regional node.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                ]
            ],
            [
                'category' => 'Problem Solving',
                'question_text' => 'A complex calculation logic needs to run on millions of records. How do you design this?',
                'options' => [
                    ['text' => 'Optimize queries, set partition tables, and configure memory allocation parameters.', 'weights' => ['DBA' => 5, 'Data Analyst' => 4]],
                    ['text' => 'Build a distributed Python map-reduce script or deploy parallel computing models.', 'weights' => ['Python' => 5, 'ML' => 4, 'AI' => 4]],
                    ['text' => 'Create a background loader script with progress bars to avoid freezing the web interface.', 'weights' => ['Frontend' => 5, 'Full Stack' => 4]],
                    ['text' => 'Deploy containerized autoscale groups on cloud services to handle compute peaks.', 'weights' => ['Cloud' => 5, 'DevOps' => 5]],
                ]
            ],

            // LEARNING STYLE (5 questions)
            [
                'category' => 'Learning Style',
                'question_text' => 'When a new programming framework is released, how do you prefer to learn it?',
                'options' => [
                    ['text' => 'Look at the API documentation and write a comprehensive test application to verify features.', 'weights' => ['Software Tester' => 5, 'Backend' => 3]],
                    ['text' => 'Read research articles and papers on its internal design, data flows, and performance gains.', 'weights' => ['AI' => 5, 'ML' => 4, 'Data Analyst' => 4]],
                    ['text' => 'Build a quick interactive landing page using the framework to see how it renders visuals.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Follow a guide to containerize it and run it inside a test cloud server cluster.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Learning Style',
                'question_text' => 'You need to explain a complex technical system to a non-technical manager. What is your strategy?',
                'options' => [
                    ['text' => 'Draw a user journey map showing how it impacts their day-to-day work tasks.', 'weights' => ['UI/UX' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Present statistical charts, ROI metrics, and data processing improvements.', 'weights' => ['Data Analyst' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Explain the architectural layers using simple hardware, database, and connection analogies.', 'weights' => ['Backend' => 5, 'Cloud' => 4, 'Full Stack' => 3]],
                    ['text' => 'Demonstrate a live automation script that achieves the target goals in one click.', 'weights' => ['Python' => 5, 'DevOps' => 3]],
                ]
            ],
            [
                'category' => 'Learning Style',
                'question_text' => 'What type of study material keeps you most engaged?',
                'options' => [
                    ['text' => 'Step-by-step tutorial checklists that culminate in a validated, bug-free project.', 'weights' => ['Software Tester' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Code challenges that involve manipulating data arrays, training weights, or algorithms.', 'weights' => ['Python' => 5, 'ML' => 5, 'AI' => 4]],
                    ['text' => 'Interactive UI playgrounds showing CSS, layout design, and element visual states.', 'weights' => ['Frontend' => 5, 'UI/UX' => 5]],
                    ['text' => 'Hands-on sandboxed command terminals configuring firewalls, Docker, or database instances.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 5, 'DBA' => 4]],
                ]
            ],
            [
                'category' => 'Learning Style',
                'question_text' => 'When debugging a system, what helps you learn the codebase fastest?',
                'options' => [
                    ['text' => 'Tracing database relationships and drawing Entity-Relationship diagrams (ERDs).', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                    ['text' => 'Running diagnostic scripts, checking raw outputs, and printing variable values.', 'weights' => ['Python' => 5, 'Data Analyst' => 4, 'ML' => 3]],
                    ['text' => 'Analyzing user event logs, clicks, and page transitions.', 'weights' => ['UI/UX' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Stepping through automatic CI pipeline build logs to identify configuration failures.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Learning Style',
                'question_text' => 'How do you keep up with cybersecurity threats and secure coding principles?',
                'options' => [
                    ['text' => 'Subscribe to vulnerability newsletters (CVE) and participate in capture-the-flag (CTF) security games.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 3]],
                    ['text' => 'Write secure sanitization classes and run security testing suites against custom endpoints.', 'weights' => ['Backend' => 5, 'Software Tester' => 4, 'Full Stack' => 3]],
                    ['text' => 'Design user registration forms that prompt users on password strengths in an elegant way.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Read corporate compliance guidelines, security standards (ISO/HIPAA), and document audit reports.', 'weights' => ['Business Analyst' => 5, 'Cloud' => 4]],
                ]
            ],

            // TECHNOLOGY INTEREST (5 questions)
            [
                'category' => 'Technology Interest',
                'question_text' => 'If you could build any technology tool over the weekend, what would it be?',
                'options' => [
                    ['text' => 'A custom relational database storage engine optimized for lightning-fast reads.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                    ['text' => 'An automated agent that summarizes news articles and classifies them by sentiment.', 'weights' => ['GenAI' => 5, 'AI' => 5, 'Python' => 4]],
                    ['text' => 'A beautiful interactive portfolio landing page with interactive dark mode toggle.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4, 'Full Stack' => 3]],
                    ['text' => 'An automated script that configures a local server firewall and alerts my phone on warnings.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 5, 'Cloud' => 3]],
                ]
            ],
            [
                'category' => 'Technology Interest',
                'question_text' => 'Which development tool do you rely on most when writing code?',
                'options' => [
                    ['text' => 'Database management tools (like DBeaver or phpMyAdmin) to inspect rows and columns.', 'weights' => ['DBA' => 5, 'Backend' => 3]],
                    ['text' => 'Jupyter Notebooks to run scripts and visualize data sets.', 'weights' => ['Python' => 5, 'Data Analyst' => 5, 'ML' => 4]],
                    ['text' => 'Browser Developer Tools (Elements panel, CSS style editor) to test pixel alignment.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Command-line terminals, Docker containers, and SSH connections.', 'weights' => ['DevOps' => 5, 'Cloud' => 4, 'Cyber Security' => 3]],
                ]
            ],
            [
                'category' => 'Technology Interest',
                'question_text' => 'What is your opinion on No-Code tools that generate web pages?',
                'options' => [
                    ['text' => 'They are useful for business analysis mockups, but lack QA testing and code scalability.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 4]],
                    ['text' => 'They cannot handle complex server architectures, APIs, and data modeling tasks.', 'weights' => ['Backend' => 5, 'Full Stack' => 4, 'DBA' => 3]],
                    ['text' => 'They provide quick visual templates but limit custom UI styling and fine-grained layouts.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'They lack infrastructure control, CI/CD integrations, and server performance monitoring.', 'weights' => ['DevOps' => 5, 'Cloud' => 5]],
                ]
            ],
            [
                'category' => 'Technology Interest',
                'question_text' => 'Which technological concept sounds most fascinating to you?',
                'options' => [
                    ['text' => 'Distributed consensus databases, query planners, and transactional security.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                    ['text' => 'Neural network layers, reinforcement learning, and transformers.', 'weights' => ['AI' => 5, 'ML' => 5, 'GenAI' => 4]],
                    ['text' => 'Dynamic client-side hydration, state synchronization, and component libraries.', 'weights' => ['Frontend' => 5, 'Full Stack' => 4]],
                    ['text' => 'Virtual private clouds, container pods orchestration, and pipeline automation.', 'weights' => ['Cloud' => 5, 'DevOps' => 5]],
                ]
            ],
            [
                'category' => 'Technology Interest',
                'question_text' => 'What kind of side projects do you find yourself researching online?',
                'options' => [
                    ['text' => 'Web application audits, pentesting frameworks, and encryption patterns.', 'weights' => ['Cyber Security' => 5, 'Backend' => 3]],
                    ['text' => 'Data scraping pipelines, data cleaning modules, and prediction models.', 'weights' => ['Python' => 5, 'Data Analyst' => 4, 'ML' => 4]],
                    ['text' => 'Color palettes, design trends, user personas, and Figma UI kits.', 'weights' => ['UI/UX' => 5, 'Frontend' => 3]],
                    ['text' => 'Serverless deployments, cloud storage architectures, and server security configurations.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                ]
            ],

            // CREATIVITY (5 questions)
            [
                'category' => 'Creativity',
                'question_text' => 'You are designing a user interface for a complex data input form. How do you make it engaging?',
                'options' => [
                    ['text' => 'Build a multi-step form wizard with progress indicators and micro-animations.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Design the form options dynamically using data analysis on previously entered inputs.', 'weights' => ['Data Analyst' => 5, 'Python' => 3]],
                    ['text' => 'Ensure the form has robust backend validation, preventing any bad records from reaching the database.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Create a solid user test case matrix to test edge-case inputs and validate errors.', 'weights' => ['Software Tester' => 5, 'Business Analyst' => 4]],
                ]
            ],
            [
                'category' => 'Creativity',
                'question_text' => 'When writing documentation, how do you present complex flows?',
                'options' => [
                    ['text' => 'Create interactive diagrams, flowcharts, and write clear user-centric documentation.', 'weights' => ['Business Analyst' => 5, 'UI/UX' => 4]],
                    ['text' => 'Provide clean, annotated code snippets and database schema mappings.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Embed charts, graphics, and metric summaries showing system outcomes.', 'weights' => ['Data Analyst' => 5, 'Python' => 3]],
                    ['text' => 'List step-by-step deployment instructions, shell commands, and docker configurations.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Creativity',
                'question_text' => 'If you had to design a new feature to increase app security, which concept would you pick?',
                'options' => [
                    ['text' => 'A gamified security audit tracker showing the safety score of user profiles.', 'weights' => ['Cyber Security' => 5, 'UI/UX' => 4]],
                    ['text' => 'An automated script scanning code submissions for hardcoded API keys.', 'weights' => ['DevOps' => 5, 'Python' => 4]],
                    ['text' => 'A custom encryption utility class implementing advanced cryptographic standards.', 'weights' => ['Backend' => 5, 'Software Tester' => 3]],
                    ['text' => 'A compliance workflow checker verifying user roles before allowing data updates.', 'weights' => ['Business Analyst' => 5, 'DBA' => 4]],
                ]
            ],
            [
                'category' => 'Creativity',
                'question_text' => 'How do you approach styling a dashboard layout?',
                'options' => [
                    ['text' => 'Tailor modern color schemes, glassmorphic panels, and clear layouts based on user research.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Focus entirely on data visualization widgets, responsive chart blocks, and tables.', 'weights' => ['Data Analyst' => 5, 'Frontend' => 3]],
                    ['text' => 'Optimize resource requests, loading metrics, and cache headers so it opens instantly.', 'weights' => ['Full Stack' => 5, 'Cloud' => 4, 'Backend' => 3]],
                    ['text' => 'Align it with corporate compliance standards and document data permission levels.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 3]],
                ]
            ],
            [
                'category' => 'Creativity',
                'question_text' => 'You want to automate a household task. What creative solution do you build?',
                'options' => [
                    ['text' => 'A Python script that scrapes weekly grocery deals and alerts me of items matching my preferences.', 'weights' => ['Python' => 5, 'Data Analyst' => 4]],
                    ['text' => 'An AI smart camera script that triggers notifications when my pet enters a restricted area.', 'weights' => ['AI' => 5, 'ML' => 4, 'GenAI' => 4]],
                    ['text' => 'A simple, clean dashboard layout displayed on a tablet to organize family tasks.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'A smart server setup running on a local Raspberry Pi managing network firewall rules.', 'weights' => ['Cloud' => 5, 'Cyber Security' => 4, 'DevOps' => 4]],
                ]
            ],

            // LEADERSHIP (5 questions)
            [
                'category' => 'Leadership',
                'question_text' => 'A junior developer is struggling with their tasks and delaying the release. What do you do?',
                'options' => [
                    ['text' => 'Break down their tasks into smaller pieces, clarify the requirements, and set daily reviews.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 4]],
                    ['text' => 'Pair program with them to debug backend issues, and teach them database best practices.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Help them build component styles, share reusable CSS patterns, and help with frontend grids.', 'weights' => ['Frontend' => 5, 'UI/UX' => 3]],
                    ['text' => 'Provide a pre-configured Docker testing sandbox and set up a deployment staging environment.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Leadership',
                'question_text' => 'There is a major disagreement in the team about which backend architecture to use. How do you resolve it?',
                'options' => [
                    ['text' => 'Analyze business requirements, project budget, and write an evaluation report for the client.', 'weights' => ['Business Analyst' => 5, 'Cloud' => 4]],
                    ['text' => 'Conduct performance benchmarking tests and compare data transactions speed for both systems.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Data Analyst' => 4]],
                    ['text' => 'Build quick wireframes and prototypes for both choices to see which one provides a better UX.', 'weights' => ['UI/UX' => 5, 'Frontend' => 3]],
                    ['text' => 'Set up staging configurations for both platforms on cloud servers to evaluate ease of deployment.', 'weights' => ['DevOps' => 5, 'Cloud' => 5]],
                ]
            ],
            [
                'category' => 'Leadership',
                'question_text' => 'What is your focus when leading a project review meeting?',
                'options' => [
                    ['text' => 'Reviewing bug reports, validation checklists, and ensuring the product is ready for production.', 'weights' => ['Software Tester' => 5, 'Business Analyst' => 3]],
                    ['text' => 'Analyzing data outputs, training metrics, and accuracy percentages of our scripts.', 'weights' => ['ML' => 5, 'Data Analyst' => 4, 'AI' => 3]],
                    ['text' => 'Reviewing visual feedback, component interfaces consistency, and accessibility standards.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Reviewing pipeline speed, server costs, load monitoring, and system security rules.', 'weights' => ['DevOps' => 5, 'Cloud' => 4, 'Cyber Security' => 4]],
                ]
            ],
            [
                'category' => 'Leadership',
                'question_text' => 'How do you ensure a team delivers secure code on time?',
                'options' => [
                    ['text' => 'Define strict security coding standards, run vulnerability scans, and inspect API controllers.', 'weights' => ['Cyber Security' => 5, 'Backend' => 4]],
                    ['text' => 'Implement mandatory automated test coverage rules on code submissions before merge.', 'weights' => ['Software Tester' => 5, 'Python' => 3]],
                    ['text' => 'Create a unified design style guide in Figma so frontend developers build matching interfaces quickly.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Establish continuous integration (CI) workflows that test and build projects automatically.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Leadership',
                'question_text' => 'A client wants to implement an expensive AI solution that you believe is unnecessary. What do you do?',
                'options' => [
                    ['text' => 'Present a detailed cost-benefit report comparing a simple rule-based script against the AI model.', 'weights' => ['Business Analyst' => 5, 'Data Analyst' => 4]],
                    ['text' => 'Explain the technical maintenance, database storage needs, and processing requirements of AI models.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Python' => 3]],
                    ['text' => 'Highlight how the AI backend would complicate the user forms and interface loading times.', 'weights' => ['UI/UX' => 5, 'Frontend' => 3]],
                    ['text' => 'Explain the cloud hosting costs, model serving infrastructure, and monitoring complexities.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                ]
            ],

            // COMMUNICATION (5 questions)
            [
                'category' => 'Communication',
                'question_text' => 'You discovered a security vulnerability in the system. How do you communicate this?',
                'options' => [
                    ['text' => 'Draft a secure incident report outlining the risk, impacted nodes, and remediation steps.', 'weights' => ['Cyber Security' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Explain the bug to backend engineers, check database logs, and deploy a quick code fix.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Create a clear alert message warning users to reset their tokens on their profiles.', 'weights' => ['Frontend' => 5, 'UI/UX' => 3]],
                    ['text' => 'Log the warning in the server monitoring dashboard and notify the infrastructure team.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Communication',
                'question_text' => 'What is the most important element of a good git Pull Request?',
                'options' => [
                    ['text' => 'A clear description of what changed, reference to user stories, and testing instructions.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 5]],
                    ['text' => 'Clean code logic, optimized SQL statements, and proper error handling structures.', 'weights' => ['Backend' => 5, 'Full Stack' => 4, 'Python' => 3]],
                    ['text' => 'Screenshots or GIFs showing how the frontend interface and styles changed.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Automated check reports showing all builds and security scans passed successfully.', 'weights' => ['DevOps' => 5, 'Cloud' => 4, 'Cyber Security' => 3]],
                ]
            ],
            [
                'category' => 'Communication',
                'question_text' => 'How do you handle stakeholder training sessions for new software?',
                'options' => [
                    ['text' => 'Create user manuals, step-by-step checklists, and walk through business test scenarios.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 4]],
                    ['text' => 'Demonstrate database records changing in real-time as inputs are made on the web forms.', 'weights' => ['DBA' => 5, 'Backend' => 3]],
                    ['text' => 'Focus entirely on demonstrating the visual interface, profile fields, and visual dashboards.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Explain the deployment setup, local server backup options, and system restore guidelines.', 'weights' => ['Cloud' => 5, 'DevOps' => 3]],
                ]
            ],
            [
                'category' => 'Communication',
                'question_text' => 'You need to explain a database migration delay to a client. How do you frame it?',
                'options' => [
                    ['text' => 'Frame it around protecting database records safety and maintaining transactional integrity.', 'weights' => ['DBA' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Provide a python data reconciliation report verifying the migration script\'s accuracy.', 'weights' => ['Python' => 5, 'Data Analyst' => 4]],
                    ['text' => 'Explain that frontend changes need validation to match the backend structure correctly.', 'weights' => ['Frontend' => 5, 'Full Stack' => 3]],
                    ['text' => 'Explain the complexity of server configurations and cloud load migrations under live traffic.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                ]
            ],
            [
                'category' => 'Communication',
                'question_text' => 'Which style of technical writing do you enjoy most?',
                'options' => [
                    ['text' => 'Functional requirements specifications, user stories, and compliance guidelines.', 'weights' => ['Business Analyst' => 5, 'Cyber Security' => 3]],
                    ['text' => 'API documentation, code annotations, and structural design patterns.', 'weights' => ['Backend' => 5, 'Full Stack' => 4, 'Python' => 3]],
                    ['text' => 'User interface style guides, typography notes, and usability audit reviews.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'Cloud server deployment scripts, environment setup manuals, and backup logs.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],

            // ANALYTICAL THINKING (5 questions)
            [
                'category' => 'Analytical Thinking',
                'question_text' => 'When looking at a company\'s data, what interests you most?',
                'options' => [
                    ['text' => 'Extracting trends, summarizing patterns, and building charts to explain business performance.', 'weights' => ['Data Analyst' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Optimizing the SQL tables and data models to query millions of rows in milliseconds.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                    ['text' => 'Training models to forecast future sales based on regression math models.', 'weights' => ['ML' => 5, 'AI' => 4, 'Python' => 4]],
                    ['text' => 'Designing user layouts to display data results in a clear, interactive way.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                ]
            ],
            [
                'category' => 'Analytical Thinking',
                'question_text' => 'How do you evaluate if a software application is ready for production release?',
                'options' => [
                    ['text' => 'Verify that all manual and automated tests have run and all known bugs are logged.', 'weights' => ['Software Tester' => 5, 'Business Analyst' => 3]],
                    ['text' => 'Run server security scans, network port audits, and check credential encryption.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 4]],
                    ['text' => 'Test frontend responsiveness on multiple mobile devices and check CSS layout integrity.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Verify that database indexes, constraints, and server storage limits are correctly configured.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                ]
            ],
            [
                'category' => 'Analytical Thinking',
                'question_text' => 'What is your approach when a script you wrote is returning incorrect outputs?',
                'options' => [
                    ['text' => 'Print intermediate variable states, write assertions, and trace math calculations step-by-step.', 'weights' => ['Python' => 5, 'ML' => 4, 'AI' => 4]],
                    ['text' => 'Check if the backend API inputs conform to expected database values and constraints.', 'weights' => ['Backend' => 5, 'DBA' => 4, 'Full Stack' => 3]],
                    ['text' => 'Compare the output values against client documentation and requirements files.', 'weights' => ['Business Analyst' => 5, 'Software Tester' => 4]],
                    ['text' => 'Check if environment variables, server versions, or Docker settings are causing conflicts.', 'weights' => ['DevOps' => 5, 'Cloud' => 4]],
                ]
            ],
            [
                'category' => 'Analytical Thinking',
                'question_text' => 'You are comparing two different database engines for a new project. How do you decide?',
                'options' => [
                    ['text' => 'Measure query latency, storage formats, transactional safety, and index performance.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                    ['text' => 'Analyze licensing costs, support options, and how well it maps to client requirements.', 'weights' => ['Business Analyst' => 5, 'Cloud' => 4]],
                    ['text' => 'Check if there are pre-built libraries to connect it to modern front-end frameworks easily.', 'weights' => ['Frontend' => 5, 'Full Stack' => 3]],
                    ['text' => 'Check if the cloud provider offers fully managed services with easy autoscale configurations.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                ]
            ],
            [
                'category' => 'Analytical Thinking',
                'question_text' => 'What is your process for checking code quality?',
                'options' => [
                    ['text' => 'Run automated code coverage tools, check unit test assertions, and verify edge cases.', 'weights' => ['Software Tester' => 5, 'Python' => 4]],
                    ['text' => 'Analyze time complexity, memory allocation efficiency, and design patterns.', 'weights' => ['Backend' => 5, 'ML' => 4, 'Full Stack' => 3]],
                    ['text' => 'Review the user interface code to ensure accessibility standards (WCAG) are met.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4]],
                    ['text' => 'Add static analysis tools in the git repository to block commits that violate code standards.', 'weights' => ['DevOps' => 5, 'Cyber Security' => 4]],
                ]
            ],

            // CURIOSITY (5 questions)
            [
                'category' => 'Curiosity',
                'question_text' => 'You hear about a major security breach in a well-known global application. What is your reaction?',
                'options' => [
                    ['text' => 'Research the exploit mechanism, read security analysis articles, and check if my apps are vulnerable.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 4]],
                    ['text' => 'Investigate the database security settings and check API inputs validation layers.', 'weights' => ['DBA' => 5, 'Backend' => 4, 'Full Stack' => 3]],
                    ['text' => 'Check if the company notified their users promptly and had a clear warning popup layout.', 'weights' => ['UI/UX' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Set up an automated script that scans my servers for outdated libraries and packages.', 'weights' => ['DevOps' => 5, 'Python' => 4]],
                ]
            ],
            [
                'category' => 'Curiosity',
                'question_text' => 'A brand new open-source Large Language Model (LLM) is released. What do you want to explore first?',
                'options' => [
                    ['text' => 'Download it locally, run python scripts to test prompt templates, and analyze context limits.', 'weights' => ['GenAI' => 5, 'AI' => 5, 'Python' => 4]],
                    ['text' => 'Find out how to host it serverless on cloud clusters and configure API endpoints.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                    ['text' => 'Evaluate if this model can automate user support forms or wireframe generation.', 'weights' => ['UI/UX' => 5, 'Business Analyst' => 4]],
                    ['text' => 'Set up a test bench to compare its validation rates against commercial APIs.', 'weights' => ['Software Tester' => 5, 'Data Analyst' => 4]],
                ]
            ],
            [
                'category' => 'Curiosity',
                'question_text' => 'You notice a weird, unexplained pattern in your application\'s access logs. What is your next move?',
                'options' => [
                    ['text' => 'Write a data script to aggregate IP locations, analyze access timestamps, and plot graphs.', 'weights' => ['Data Analyst' => 5, 'Python' => 4, 'ML' => 3]],
                    ['text' => 'Inspect server networks, check port bindings, and scan for potential intrusion attempts.', 'weights' => ['Cyber Security' => 5, 'DevOps' => 4]],
                    ['text' => 'Review user registration flows to see if a UX issue is causing repeated attempts.', 'weights' => ['UI/UX' => 5, 'Business Analyst' => 3]],
                    ['text' => 'Examine database locking records to see if queries are backing up on specific tables.', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                ]
            ],
            [
                'category' => 'Curiosity',
                'question_text' => 'What is a topic you find yourself reading about just for fun?',
                'options' => [
                    ['text' => 'Ethical machine learning, data privacy debates, and the limits of intelligence models.', 'weights' => ['AI' => 5, 'ML' => 5, 'GenAI' => 4]],
                    ['text' => 'Case studies of massive infrastructure migrations, cloud outages, or scale solutions.', 'weights' => ['Cloud' => 5, 'DevOps' => 4]],
                    ['text' => 'How color choices, spacing, and page elements influence human behavior and emotions.', 'weights' => ['UI/UX' => 5, 'Frontend' => 4]],
                    ['text' => 'How database index systems work internally (B-Trees vs Hash maps).', 'weights' => ['DBA' => 5, 'Backend' => 4]],
                ]
            ],
            [
                'category' => 'Curiosity',
                'question_text' => 'You are visiting a website with an amazing interactive experience. What do you do?',
                'options' => [
                    ['text' => 'Inspect the webpage code to see what CSS and JS frameworks or libraries they used.', 'weights' => ['Frontend' => 5, 'UI/UX' => 4, 'Full Stack' => 3]],
                    ['text' => 'Think about the server throughput and database scaling required to serve such content.', 'weights' => ['Backend' => 5, 'Cloud' => 4, 'DBA' => 3]],
                    ['text' => 'Map out the user onboarding flow and write a case study on their conversion funnel.', 'weights' => ['Business Analyst' => 5, 'UI/UX' => 4]],
                    ['text' => 'Run browser accessibility checks and verify form inputs validation states.', 'weights' => ['Software Tester' => 5, 'Frontend' => 3]],
                ]
            ]
        ];

        foreach ($questionsData as $qData) {
            $question = Question::create([
                'question_text' => $qData['question_text'],
                'category' => $qData['category'],
            ]);

            foreach ($qData['options'] as $optData) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optData['text'],
                    'career_weights' => $optData['weights'],
                ]);
            }
        }
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
    </style>
</head>
<body class="bg-slate-100 text-gray-800 antialiased">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white/90 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm overflow-hidden">
                            <img src="{{ asset('images/sirms-logo.png') }}" alt="SIRMS Logo" class="h-8 w-8 object-contain">
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900 leading-none">SIRMS</h1>
                            <p class="text-sm text-gray-500">Security Incident Reporting and Management System</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}"
                           class="px-5 py-2.5 text-sm font-semibold text-blue-600 border border-blue-200 rounded-xl hover:bg-blue-50 transition duration-200">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="px-6 py-2.5 text-sm font-semibold bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 hover:scale-105 transition duration-200">
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-slate-100">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-10 left-[-80px] w-80 h-80 bg-blue-200 rounded-full blur-3xl opacity-30"></div>
                <div class="absolute bottom-10 right-[-80px] w-80 h-80 bg-slate-300 rounded-full blur-3xl opacity-30"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 py-24 lg:py-32">
                <div class="max-w-4xl mx-auto text-center">

                    <span class="inline-flex items-center px-5 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-8 shadow-sm">
                        Web-Based Security Incident Platform
                    </span>

                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 leading-tight mb-6 animate-fade-in">
                        Centralized Security Incident
                        <br>
                        <span class="text-blue-600">Reporting &amp; Management</span>
                    </h1>

                    <p class="max-w-3xl mx-auto text-lg md:text-xl text-gray-600 leading-relaxed mb-10">
                        A centralized platform for reporting, tracking, investigating, and managing
                        security incidents through structured workflows, role-based access control,
                        and accountable incident handling.
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                        <a href="{{ route('login') }}"
                           class="px-8 py-4 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 hover:scale-105 transition duration-200">
                            Login to Dashboard
                        </a>

                        <a href="{{ route('register') }}"
                           class="px-8 py-4 rounded-2xl bg-white text-slate-800 font-semibold border border-gray-300 shadow hover:bg-gray-50 hover:scale-105 transition duration-200">
                            Start Reporting Incidents
                        </a>
                    </div>

                    <!-- Trust / Security Badges -->
                    <div class="flex flex-wrap justify-center gap-6 mt-8 text-sm text-slate-500">
                        <span class="flex items-center gap-2">🔐 Secure Authentication</span>
                        <span class="flex items-center gap-2">🛡 Role-Based Access Control</span>
                        <span class="flex items-center gap-2">📁 Evidence File Upload</span>
                        <span class="flex items-center gap-2">📊 Incident Analytics Dashboard</span>
                    </div>

                    <!-- Metrics -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-5xl mx-auto mt-12 mb-16">
                        <div class="rounded-2xl bg-white/80 backdrop-blur-md border border-white shadow-md p-5">
                            <p class="text-3xl font-bold text-blue-600">3</p>
                            <p class="text-sm text-slate-500 mt-1">User Roles</p>
                        </div>

                        <div class="rounded-2xl bg-white/80 backdrop-blur-md border border-white shadow-md p-5">
                            <p class="text-3xl font-bold text-blue-600">24/7</p>
                            <p class="text-sm text-slate-500 mt-1">Incident Tracking</p>
                        </div>

                        <div class="rounded-2xl bg-white/80 backdrop-blur-md border border-white shadow-md p-5">
                            <p class="text-3xl font-bold text-blue-600">PDF/CSV</p>
                            <p class="text-sm text-slate-500 mt-1">Report Export</p>
                        </div>

                        <div class="rounded-2xl bg-white/80 backdrop-blur-md border border-white shadow-md p-5">
                            <p class="text-3xl font-bold text-blue-600">100%</p>
                            <p class="text-sm text-slate-500 mt-1">Audit Visibility</p>
                        </div>
                    </div>

                    <!-- Highlight Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto">
                        <div class="bg-white/70 backdrop-blur-md border border-white shadow-md rounded-2xl p-6">
                            <h3 class="text-2xl font-bold text-blue-600">Centralized</h3>
                            <p class="text-gray-600 text-sm mt-2">Incident Reporting</p>
                        </div>

                        <div class="bg-white/70 backdrop-blur-md border border-white shadow-md rounded-2xl p-6">
                            <h3 class="text-2xl font-bold text-blue-600">Role-Based</h3>
                            <p class="text-gray-600 text-sm mt-2">Access Control</p>
                        </div>

                        <div class="bg-white/70 backdrop-blur-md border border-white shadow-md rounded-2xl p-6">
                            <h3 class="text-2xl font-bold text-blue-600">Traceable</h3>
                            <p class="text-gray-600 text-sm mt-2">Audit Logging</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- System Objective -->
        <section class="py-20 bg-white">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">
                    System Objective
                </h2>

                <p class="text-lg text-gray-600 leading-relaxed">
                    The Security Incident Reporting and Management System (SIRMS) is developed
                    to improve incident visibility, streamline investigation workflows, and
                    enhance accountability in security operations. The system centralizes incident
                    reporting, supports role-based coordination, and ensures traceable handling
                    through structured audit logging.
                </p>
            </div>
        </section>

        <!-- Features -->
        <section class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                        Core System Modules
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Designed to support structured incident submission, management, investigation,
                        communication, and administrative monitoring.
                    </p>
                </div>

                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl mb-6 shadow-sm">
                            📝
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">
                            Structured Incident Reporting
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Users can submit security incidents with category, severity level,
                            description, and supporting evidence through a standardized reporting form.
                        </p>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-red-100 text-red-500 flex items-center justify-center text-3xl mb-6 shadow-sm">
                            🔎
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">
                            Incident Management Workflow
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Administrators can validate, classify, assign, and escalate incidents,
                            while assigned officers investigate cases and update findings until closure.
                        </p>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-slate-200 text-slate-700 flex items-center justify-center text-3xl mb-6 shadow-sm">
                            📊
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">
                            Audit Logs and Analytics
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            The system records critical actions, supports dashboard-based monitoring,
                            and enables exportable reports for management review and documentation.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Key Capabilities -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">
                        Key System Capabilities
                    </h2>
                    <p class="text-lg text-gray-600">
                        SIRMS provides practical features to support structured and accountable incident handling.
                    </p>
                </div>

                <div class="max-w-4xl mx-auto bg-slate-50 border border-slate-200 rounded-3xl p-8 shadow-sm">
                    <ul class="text-left text-gray-600 space-y-4">
                        <li>• Secure authentication with email verification</li>
                        <li>• Structured incident submission with evidence upload</li>
                        <li>• Role-based incident assignment and workflow control</li>
                        <li>• Investigation notes and communication tracking</li>
                        <li>• Audit logging for accountability and traceability</li>
                        <li>• Dashboard analytics and report export in PDF and CSV formats</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                        How It Works
                    </h2>
                    <p class="text-lg text-gray-600">
                        A simple workflow for reporting, reviewing, investigating, and resolving incidents.
                    </p>
                </div>

                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm text-center hover:shadow-lg transition">
                        <div class="text-3xl font-bold text-blue-600 mb-4">1</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Report</h3>
                        <p class="text-gray-600">
                            Users submit incidents with detailed descriptions and supporting evidence.
                        </p>
                    </div>

                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm text-center hover:shadow-lg transition">
                        <div class="text-3xl font-bold text-blue-600 mb-4">2</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Review</h3>
                        <p class="text-gray-600">
                            Administrators validate and classify each incident for proper handling.
                        </p>
                    </div>

                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm text-center hover:shadow-lg transition">
                        <div class="text-3xl font-bold text-blue-600 mb-4">3</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Investigate</h3>
                        <p class="text-gray-600">
                            Assigned officers investigate cases, update progress, and document findings.
                        </p>
                    </div>

                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm text-center hover:shadow-lg transition">
                        <div class="text-3xl font-bold text-blue-600 mb-4">4</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Resolve</h3>
                        <p class="text-gray-600">
                            Incidents are resolved, tracked, and recorded for accountability and review.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Technology Stack -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-slate-900 mb-10">
                    Technology Stack
                </h2>

                <div class="grid md:grid-cols-4 gap-6">
                    <div class="bg-slate-50 rounded-2xl p-6 shadow border border-slate-200">
                        <h3 class="font-bold text-blue-600 text-xl">Laravel</h3>
                        <p class="text-sm text-gray-500 mt-2">Backend Framework</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 shadow border border-slate-200">
                        <h3 class="font-bold text-blue-600 text-xl">MySQL</h3>
                        <p class="text-sm text-gray-500 mt-2">Database System</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 shadow border border-slate-200">
                        <h3 class="font-bold text-blue-600 text-xl">Tailwind CSS</h3>
                        <p class="text-sm text-gray-500 mt-2">User Interface Styling</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 shadow border border-slate-200">
                        <h3 class="font-bold text-blue-600 text-xl">RBAC</h3>
                        <p class="text-sm text-gray-500 mt-2">Security Access Model</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Roles -->
        <section class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl font-bold text-slate-900 mb-4">
                        Role-Based User Access
                    </h2>
                    <p class="text-lg text-gray-600">
                        SIRMS supports different responsibilities for reporters, administrators, and assigned officers.
                    </p>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm hover:shadow-lg transition">
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Reporter</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li>• Submit incident reports</li>
                            <li>• Upload supporting evidence</li>
                            <li>• Track incident status</li>
                            <li>• Communicate with administrators</li>
                        </ul>
                    </div>

                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm hover:shadow-lg transition">
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Administrator</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li>• Validate and classify incidents</li>
                            <li>• Assign or reassign cases</li>
                            <li>• Escalate incidents when needed</li>
                            <li>• Monitor dashboards and reports</li>
                        </ul>
                    </div>

                    <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm hover:shadow-lg transition">
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Assigned Officer</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li>• View assigned incidents</li>
                            <li>• Perform investigations</li>
                            <li>• Update investigation notes</li>
                            <li>• Resolve and close incidents</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-24 bg-slate-900 text-white">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-5">
                    Improve incident visibility and response efficiency
                </h2>
                <p class="text-lg text-slate-300 max-w-3xl mx-auto mb-8">
                    Manage incident reporting, investigation, communication, and accountability
                    in one centralized platform designed for structured security operations.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}"
                       class="px-8 py-4 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 transition">
                        Start Reporting
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-8 py-4 rounded-2xl border border-slate-500 text-white font-semibold hover:bg-slate-800 transition">
                        Access System
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-950 text-slate-400 py-8">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-3 text-sm">
                <div class="text-center md:text-left">
                    <p>Security Incident Reporting and Management System (SIRMS)</p>
                    <p class="text-xs text-slate-500 mt-1">
                        Developed as a Final Year Project for Bachelor of Information Security
                    </p>
                </div>
                <p>© {{ date('Y') }} All rights reserved.</p>
            </div>
        </footer>

    </div>

</body>
</html>
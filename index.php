<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CarePlus Hospital | Appointment & OPD Management</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            background: #f8fbff;
            line-height: 1.6;
        }

        /* =========================
           NAVBAR
        ========================= */

        nav {
            background: #ffffff;
            padding: 15px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            color: #0077b6;
            font-size: 24px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: #0077b6;
        }

        .login-btn {
            background: #0077b6;
            color: white !important;
            padding: 9px 16px;
            border-radius: 5px;
        }

        /* =========================
           HERO
        ========================= */

        .hero {
            min-height: 520px;
            display: flex;
            align-items: center;
            padding: 60px 7%;
            background: linear-gradient(
                135deg,
                #e8f7ff,
                #ffffff
            );
        }

        .hero-content {
            width: 55%;
        }

        .hero h1 {
            font-size: 48px;
            color: #023e8a;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .primary-btn {
            background: #0077b6;
            color: white;
            padding: 13px 22px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .secondary-btn {
            border: 2px solid #0077b6;
            color: #0077b6;
            padding: 11px 22px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .primary-btn:hover {
            background: #005f8f;
        }

        .secondary-btn:hover {
            background: #0077b6;
            color: white;
        }

        /* =========================
           SECTION
        ========================= */

        .section {
            padding: 60px 7%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            color: #023e8a;
            font-size: 32px;
        }

        .section-title p {
            color: #666;
        }

        /* =========================
           SERVICES
        ========================= */

        .services {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .service-card {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .service-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .service-card h3 {
            color: #0077b6;
            margin-bottom: 10px;
        }

        /* =========================
           DEPARTMENTS
        ========================= */

        .departments {
            background: #eef8ff;
        }

        .department-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .department {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            color: #023e8a;
        }

        /* =========================
           CTA
        ========================= */

        .cta {
            text-align: center;
            padding: 70px 7%;
            background: #0077b6;
            color: white;
        }

        .cta h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .cta p {
            margin-bottom: 25px;
        }

        .cta a {
            background: white;
            color: #0077b6;
            padding: 13px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #023e8a;
            color: white;
            padding: 30px 7%;
            text-align: center;
        }

        footer p {
            margin: 5px 0;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 800px) {

            .nav-links {
                gap: 10px;
                font-size: 14px;
            }

            .hero {
                text-align: center;
            }

            .hero-content {
                width: 100%;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero-buttons {
                justify-content: center;
                flex-wrap: wrap;
            }

            .services,
            .department-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<nav>

    <div class="logo">

        🏥 CarePlus Hospital

    </div>


    <div class="nav-links">

        <a href="index.php">
            Home
        </a>

        <a href="#services">
            Services
        </a>

        <a href="#departments">
            Departments
        </a>

        <a href="login.php" class="login-btn">
            Patient Login
        </a>

    </div>

</nav>


<!-- =========================
     HERO
========================= -->

<section class="hero">

    <div class="hero-content">

        <h1>
            Quality Healthcare,
            When You Need It
        </h1>

        <p>

            Book hospital appointments easily,
            manage your OPD visits, and stay
            connected with your healthcare services.

        </p>


        <div class="hero-buttons">

            <a
                href="register.php"
                class="primary-btn"
            >
                Register as Patient
            </a>


            <a
                href="login.php"
                class="secondary-btn"
            >
                Patient Login
            </a>

        </div>

    </div>

</section>


<!-- =========================
     SERVICES
========================= -->

<section class="section" id="services">

    <div class="section-title">

        <h2>
            Our Services
        </h2>

        <p>
            Simple and convenient healthcare management
        </p>

    </div>


    <div class="services">


        <div class="service-card">

            <div class="service-icon">
                📅
            </div>

            <h3>
                Online Appointments
            </h3>

            <p>
                Book your OPD appointment
                with your preferred doctor.
            </p>

        </div>


        <div class="service-card">

            <div class="service-icon">
                👨‍⚕️
            </div>

            <h3>
                Qualified Doctors
            </h3>

            <p>
                Connect with doctors across
                multiple medical departments.
            </p>

        </div>


        <div class="service-card">

            <div class="service-icon">
                📋
            </div>

            <h3>
                OPD Management
            </h3>

            <p>
                Easily track your appointments
                and OPD visit status.
            </p>

        </div>


    </div>

</section>


<!-- =========================
     DEPARTMENTS
========================= -->

<section
    class="section departments"
    id="departments"
>

    <div class="section-title">

        <h2>
            Our Departments
        </h2>

        <p>
            Medical services for your healthcare needs
        </p>

    </div>


    <div class="department-grid">


        <div class="department">
            🩺 General Medicine
        </div>


        <div class="department">
            ❤️ Cardiology
        </div>


        <div class="department">
            🦴 Orthopedics
        </div>


        <div class="department">
            🧠 Neurology
        </div>


        <div class="department">
            👶 Pediatrics
        </div>


        <div class="department">
            🧴 Dermatology
        </div>


    </div>

</section>


<!-- =========================
     CTA
========================= -->

<section class="cta">

    <h2>
        Need a Doctor?
    </h2>

    <p>
        Book your OPD appointment today.
    </p>

    <a href="register.php">
        Book an Appointment
    </a>

</section>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <h3>
        🏥 CarePlus Hospital
    </h3>

    <p>
        Hospital Appointment & OPD Management System
    </p>

    <p>
        📞 +91 98765 43210 |
        ✉️ careplus@example.com
    </p>

    <p>
        © 2026 CarePlus Hospital. All Rights Reserved.
    </p>

</footer>


</body>

</html>

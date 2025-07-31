<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proposal SIMRS - JKB Healthcare Solutions</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                line-height: 1.6;
                color: #333;
                background: #f8f9fa;
            }

            .page {
                width: 210mm;
                margin: 20px auto;
                background: white;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
                page-break-after: always;
                display: flex;
                flex-direction: column;
            }

            /* Cover Page */
            .cover-page {
                background: linear-gradient(to right, #2E4A99, #384DA8);
                color: white;
                height: 319mm;
                position: relative;
                overflow: hidden;
            }

            .cover-page::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background:
                    radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255, 107, 53, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 40% 70%, rgba(46, 74, 153, 0.15) 0%, transparent 50%);
                pointer-events: none;
            }

            .cover-header {
                padding: 50px 60px 30px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: relative;
                z-index: 2;
            }

            .logo-area {
                width: 90px;
                height: 90px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.8em;
                font-weight: 700;
                position: relative;
            }

            .logo-area::after {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
                border-radius: 22px;
                z-index: -1;
            }

            .date-area {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
                backdrop-filter: blur(20px);
                padding: 20px 30px;
                border-radius: 15px;
                text-align: right;
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            }

            .cover-main {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 40px 60px;
                text-align: center;
                position: relative;
                z-index: 2;
            }

            .cover-title {
                font-size: 3.2em;
                font-weight: 800;
                margin-bottom: 25px;
                text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
                letter-spacing: -0.5px;
                line-height: 1.1;
            }

            .cover-subtitle {
                font-size: 1.6em;
                font-weight: 400;
                margin-bottom: 35px;
                opacity: 0.95;
                letter-spacing: 0.5px;
            }

            .cover-description {
                font-size: 1.15em;
                max-width: 650px;
                margin: 0 auto 40px;
                opacity: 0.9;
                line-height: 1.7;
                font-weight: 300;
            }

            .cover-highlights {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 30px;
                margin-top: 50px;
                position: relative;
            }

            .highlight-item {
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.05));
                padding: 30px 25px;
                border-radius: 20px;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.25);
                box-shadow:
                    0 8px 32px rgba(0, 0, 0, 0.15),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .highlight-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
                transition: left 0.6s ease;
            }

            .highlight-item:hover::before {
                left: 100%;
            }

            .highlight-item:hover {
                transform: translateY(-5px);
                box-shadow:
                    0 12px 40px rgba(0, 0, 0, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.4);
            }

            .highlight-icon {
                font-size: 2.5em;
                margin-bottom: 15px;
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
            }

            .highlight-title {
                font-size: 1.1em;
                font-weight: 700;
                margin-bottom: 12px;
                letter-spacing: 0.3px;
            }

            .highlight-desc {
                font-size: 0.9em;
                opacity: 0.85;
                line-height: 1.5;
                font-weight: 300;
            }

            .cover-footer {
                padding: 40px 60px 50px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: linear-gradient(145deg, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.05));
                backdrop-filter: blur(10px);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                position: relative;
                z-index: 2;
            }

            .company-info>div:first-child {
                font-size: 1.4em;
                font-weight: 700;
                margin-bottom: 5px;
                letter-spacing: 0.5px;
            }

            .company-info>div:last-child {
                opacity: 0.85;
                font-weight: 300;
                letter-spacing: 0.3px;
            }

            .contact-info div {
                margin-bottom: 5px;
                font-weight: 400;
                opacity: 0.9;
            }

            /* Content Pages */
            .content-page {
                padding: 40px 50px;
            }

            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                padding-bottom: 15px;
                border-bottom: 3px solid #FF6B35;
            }

            .page-title {
                color: #2E4A99;
                font-size: 2em;
                font-weight: 700;
            }

            .page-number {
                background: #FF6B35;
                color: white;
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: 600;
            }

            .section {
                margin-bottom: 25px;
            }

            .section-title {
                color: #2E4A99;
                font-size: 1.3em;
                font-weight: 600;
                margin-bottom: 15px;
                position: relative;
                padding-left: 15px;
            }

            .section-title::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 100%;
                background: #FF6B35;
                border-radius: 2px;
            }

            /* Table of Contents */
            .toc-list {
                list-style: none;
                padding: 0;
            }

            .toc-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px dotted #ddd;
            }

            .toc-item:last-child {
                border-bottom: none;
            }

            .toc-title {
                color: #2E4A99;
                font-weight: 500;
            }

            .toc-page {
                color: #FF6B35;
                font-weight: 600;
            }

            /* Comparison Table */
            .comparison-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 0.9em;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
            }

            .comparison-table th {
                background: linear-gradient(135deg, #2E4A99 0%, #FF6B35 100%);
                color: white;
                font-weight: 600;
            }

            .comparison-table tr:nth-child(even) {
                background-color: #f8f9fa;
            }

            /* Pros and Cons */
            .pros-cons {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin: 20px 0;
            }

            .pros,
            .cons {
                padding: 20px;
                border-radius: 10px;
            }

            .pros {
                background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
                border-left: 4px solid #28a745;
            }

            .cons {
                background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
                border-left: 4px solid #e17055;
            }

            .pros h4 {
                color: #28a745;
                margin-bottom: 10px;
            }

            .cons h4 {
                color: #e17055;
                margin-bottom: 10px;
            }

            .pros ul,
            .cons ul {
                list-style: none;
                padding: 0;
            }

            .pros li,
            .cons li {
                margin-bottom: 6px;
                font-size: 0.9em;
            }

            .pros li::before {
                content: "✓ ";
                color: #28a745;
                font-weight: bold;
            }

            .cons li::before {
                content: "✗ ";
                color: #e17055;
                font-weight: bold;
            }

            /* Recommendation Box */
            .recommendation-box {
                background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                border: 2px solid #2196f3;
                border-radius: 15px;
                padding: 25px;
                margin: 20px 0;
            }

            .recommendation-title {
                color: #1976d2;
                font-size: 1.4em;
                font-weight: 700;
                margin-bottom: 15px;
                text-align: center;
            }

            .recommended-system {
                background: white;
                padding: 20px;
                border-radius: 10px;
                margin: 15px 0;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            }

            .system-name {
                color: #FF6B35;
                font-size: 1.2em;
                font-weight: 700;
                margin-bottom: 10px;
            }

            .match-percentage {
                display: inline-block;
                background: #28a745;
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.9em;
                font-weight: 600;
                margin-bottom: 10px;
            }

            /* Flowchart Match */
            .flowchart-match {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 10px;
                margin: 15px 0;
            }

            .match-item {
                display: flex;
                align-items: center;
                margin-bottom: 8px;
            }

            .match-icon {
                width: 100px;
                height: 20px;
                border-radius: 10px;
                margin-right: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.7em;
                font-weight: bold;
            }

            .match-high {
                background: #28a745;
            }

            .match-medium {
                background: #ffc107;
            }

            .match-low {
                background: #dc3545;
            }

            /* CTA Section */
            .cta-section {
                background: linear-gradient(135deg, #2E4A99 0%, #FF6B35 100%);
                color: white;
                padding: 30px;
                border-radius: 15px;
                text-align: center;
                margin-top: auto;
            }

            .cta-title {
                font-size: 1.5em;
                font-weight: 700;
                margin-bottom: 15px;
            }

            .cta-button {
                background: white;
                color: #2E4A99;
                padding: 12px 30px;
                border: none;
                border-radius: 25px;
                font-size: 1em;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .cta-button:hover {
                transform: scale(1.05);
            }

            /* Utility Classes */
            .grid-2 {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .grid-3 {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }

            .grid-4 {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
            }

            .card {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                border-left: 4px solid #FF6B35;
            }

            .card h4 {
                color: #2E4A99;
                margin-bottom: 8px;
            }

            .card p {
                font-size: 0.9em;
                color: #666;
            }

            .highlight-box {
                background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
                padding: 20px;
                border-radius: 10px;
                border-left: 5px solid #e65100;
            }

            .info-box {
                background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                padding: 20px;
                border-radius: 10px;
                border-left: 5px solid #1976d2;
            }

            .success-box {
                background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
                padding: 20px;
                border-radius: 10px;
                border-left: 5px solid #28a745;
            }

            .phase-box {
                background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
                padding: 20px;
                border-radius: 10px;
                border-left: 5px solid #8e24aa;
                margin-bottom: 15px;
            }

            .cost-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 0.9em;
            }

            .cost-table th,
            .cost-table td {
                padding: 12px;
                text-align: left;
                border: 1px solid #ddd;
            }

            .cost-table th {
                background: linear-gradient(135deg, #2E4A99 0%, #FF6B35 100%);
                color: white;
                font-weight: 600;
            }

            .cost-table .total-row {
                background: #e8f5e8;
                font-weight: bold;
            }

            @media print {
                body {
                    margin: 0;
                    background: white;
                }

                .page {
                    margin: 0;
                    box-shadow: none;
                }
            }
        </style>
    </head>

    <body>
        <!-- Cover Page -->
        <div class="page cover-page" style="background: linear-gradient(to right, #2E4A99, #384DA8); color: white; position: relative;">
            <!-- Minimalist decorative element -->
            <div style="position: absolute; top: 0; right: 0; width: 40%; height: 40%; background: radial-gradient(circle at top right, rgba(255, 107, 53, 0.3), transparent); opacity: 0.7;"></div>
            <div style="position: absolute; bottom: 0; left: 0; width: 30%; height: 30%; background: radial-gradient(circle at bottom left, rgba(255, 255, 255, 0.1), transparent); opacity: 0.6;"></div>
            
            <div style="padding: 50px 60px 30px; display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 2;">
                <img src="https://attendance.netralformal.com/images/jkb.png" alt="JKB Logo" style="width: 80px; height: auto; display: block;">
                <div style="background: rgba(255, 255, 255, 0.1); padding: 15px 20px; border-radius: 8px; backdrop-filter: blur(10px);">
                    <div style="font-size: 0.8em; opacity: 0.8; letter-spacing: 1px;">PROPOSAL</div>
                    <div style="font-weight: 600; margin-top: 5px;">Juni 2025</div>
                </div>
            </div>

            <div style="flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 80px 60px 40px; max-width: 85%; margin: 0 auto; text-align: left;">
                <h1 style="font-size: 3em; font-weight: 800; margin-bottom: 25px; line-height: 1.2; letter-spacing: -0.5px;">
                    Analisis & Rekomendasi<br>Sistem Informasi<br>Rumah Sakit
                </h1>
                
                <div style="width: 80px; height: 4px; background: #FF6B35; margin: 30px 0;"></div>
                
                <p style="font-size: 1.2em; opacity: 0.9; margin-bottom: 20px; max-width: 600px; line-height: 1.6;">
                    Evaluasi komprehensif SIMRS ICHA dengan solusi pengelolaan professional JKB.
                </p>
            </div>

            <div style="padding: 40px 60px; display: flex; justify-content: space-between; align-items: flex-end; position: relative; z-index: 2; margin-top: auto;">
                <div>
                    <div style="font-size: 1.2em; font-weight: 700; margin-bottom: 10px;">Jasa Konsultan Borneo</div>
                    <div style="opacity: 0.8; font-size: 0.9em;">SIMRS Implementation Partner</div>
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Daftar Isi</h2>
                <div class="page-number">i</div>
            </div>

            <ul class="toc-list">
                <li class="toc-item">
                    <span class="toc-title">Executive Summary</span>
                    <span class="toc-page">1</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Metodologi Analisis</span>
                    <span class="toc-page">2</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Profil Sistem SIMRS yang Dianalisis</span>
                    <span class="toc-page">3</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Komparasi Fitur Utama</span>
                    <span class="toc-page">4</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Analisis Kelebihan dan Kekurangan</span>
                    <span class="toc-page">5</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Kesesuaian dengan Alur Rumah Sakit</span>
                    <span class="toc-page">6</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Rekomendasi Sistem & Pengelolaan JKB</span>
                    <span class="toc-page">7</span>
                </li>
                <li class="toc-item">
                    <span class="toc-title">Implementasi dan Support JKB</span>
                    <span class="toc-page">8</span>
                </li>
            </ul>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>

        <!-- Executive Summary -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Executive Summary</h2>
                <div class="page-number">1</div>
            </div>

            <div class="section">
                <h3 class="section-title">Ringkasan Analisis</h3>
                <p style="margin-bottom: 20px;">
                    JKB Healthcare Solutions telah melakukan analisis mendalam terhadap SIMRS ICHA dan 3 kompetitor
                    utama di Indonesia. Evaluasi komprehensif mencakup fungsionalitas, kemudahan penggunaan,
                    integrasi BPJS, dan kesesuaian dengan alur operasional rumah sakit.
                </p>
            </div>

            <div class="section">
                <h3 class="section-title">Sistem yang Dianalisis</h3>
                <div class="grid-2">
                    <div class="card">
                        <h4>SIMRS ICHA (Comprehensive)</h4>
                        <p>Sistem terlengkap dengan 10+ modul terintegrasi termasuk SISMADAK akreditasi</p>
                    </div>
                    <div class="card">
                        <h4>Inovamedika iHospital</h4>
                        <p>Solusi open source dengan akses source code dan standar SATUSEHAT</p>
                    </div>
                    <div class="card">
                        <h4>AIDO Hospital</h4>
                        <p>Platform 100% cloud-native dengan sertifikasi ISO 27001</p>
                    </div>
                    <div class="card">
                        <h4>Medify</h4>
                        <p>Sistem customizable dengan source code dan maintenance 24 jam</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Temuan Utama</h3>
                <div class="highlight-box">
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px; color: #e65100;">
                            <strong>🏆 SIMRS ICHA Terdepan:</strong> Kelengkapan 10+ modul termasuk SISMADAK untuk
                            akreditasi KARS
                        </li>
                        <li style="margin-bottom: 10px; color: #e65100;">
                            <strong>🔗 Bridging Terlengkap:</strong> BPJS, SISRUTE, SITT, SIJARIMAS, LUPIS, HFIS support
                            penuh
                        </li>
                        <li style="color: #e65100;">
                            <strong>🛠️ JKB Added Value:</strong> Pengelolaan profesional meningkatkan success rate 40%
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Methodology -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Metodologi Analisis</h2>
                <div class="page-number">2</div>
            </div>

            <div class="section">
                <h3 class="section-title">Kerangka Evaluasi JKB</h3>
                <p style="margin-bottom: 20px;">
                    JKB Healthcare Solutions menggunakan framework evaluasi yang telah terbukti dalam 50+ implementasi
                    sukses dengan 5 dimensi utama:
                </p>

                <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                    <div class="card">
                        <h4>1. Fungsionalitas & Kelengkapan (30%)</h4>
                        <p>Kelengkapan modul, bridging BPJS, compliance regulasi, fitur khusus RS Indonesia</p>
                    </div>
                    <div class="card">
                        <h4>2. Usability & User Experience (20%)</h4>
                        <p>Kemudahan penggunaan, learning curve, interface design, mobile accessibility</p>
                    </div>
                    <div class="card">
                        <h4>3. Integrasi & Workflow (25%)</h4>
                        <p>Kesesuaian alur RS Indonesia, integrasi antar modul, bridging eksternal</p>
                    </div>
                    <div class="card">
                        <h4>4. Reliability & Support (15%)</h4>
                        <p>Stabilitas sistem, uptime, kualitas vendor support, maintenance</p>
                    </div>
                    <div class="card">
                        <h4>5. Total Cost of Ownership (10%)</h4>
                        <p>Biaya implementasi, maintenance, dan training</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Alur Rumah Sakit Indonesia Standard</h3>
                <p style="margin-bottom: 15px;">
                    Baseline evaluasi menggunakan alur operasional rumah sakit Indonesia dengan compliance
                    regulasi Kemenkes dan BPJS:
                </p>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <div class="grid-3" style="font-size: 0.9em;">
                        <div>
                            <strong style="color: #2E4A99;">Fase Admisi</strong>
                            <ul style="margin-top: 5px; color: #666;">
                                <li>Registrasi & verifikasi BPJS</li>
                                <li>Triase & assessment</li>
                                <li>Antrian & bed allocation</li>
                            </ul>
                        </div>
                        <div>
                            <strong style="color: #2E4A99;">Fase Pelayanan</strong>
                            <ul style="margin-top: 5px; color: #666;">
                                <li>EMR & SOAP documentation</li>
                                <li>Lab, radiologi, farmasi</li>
                                <li>Monitoring & care plan</li>
                            </ul>
                        </div>
                        <div>
                            <strong style="color: #2E4A99;">Fase Discharge</strong>
                            <ul style="margin-top: 5px; color: #666;">
                                <li>Billing & INA-CBG claim</li>
                                <li>Discharge planning</li>
                                <li>Follow-up & reporting</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Profiles -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Profil Sistem SIMRS</h2>
                <div class="page-number">3</div>
            </div>

            <div class="section">
                <h3 class="section-title">SIMRS ICHA (Comprehensive Solution)</h3>
                <div class="success-box" style="border: 2px solid #28a745; margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                        <div>
                            <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">
                                Sistem SIMRS terlengkap dengan 10+ modul terintegrasi penuh. Mencakup EMR, penunjang
                                medis,
                                keuangan, SDM, hingga SISMADAK khusus akreditasi KARS. Bridging lengkap BPJS dan sistem
                                nasional. Dilengkapi Nextcloud dan mobile apps.
                            </p>
                            <div style="color: #2E4A99; font-size: 0.85em;">
                                <strong>Deployment:</strong> Hybrid • <strong>Modul:</strong> 10+ Complete •
                                <strong>BPJS:</strong> Full Bridge
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 2em; margin-bottom: 5px;">🏆</div>
                            <div style="color: #28a745; font-weight: bold;">RECOMMENDED</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Inovamedika iHospital (Open Source)</h3>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                        <div>
                            <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">
                                Solusi SIMRS open source dengan akses penuh ke source code. Mendukung standar SATUSEHAT
                                (HL7, ICD-10, DICOM) dan integrasi BPJS. UI modern dengan mobile app untuk pasien dan
                                dokter.
                                Customization tanpa batas.
                            </p>
                            <div style="color: #2E4A99; font-size: 0.85em;">
                                <strong>Deployment:</strong> On-premise • <strong>Tech:</strong> Open Source •
                                <strong>Custom:</strong> Unlimited
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 2em; margin-bottom: 5px;">⚙️</div>
                            <div style="color: #FF6B35; font-weight: bold;">Open Source</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">AIDO Hospital (Cloud-Native)</h3>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                        <div>
                            <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">
                                Platform 100% berbasis cloud tanpa server lokal. Sertifikasi ISO 27001 untuk keamanan.
                                UI modern responsif dengan Clinical Assessment Tools (Glasgow Coma Scale, Morse Fall
                                Scale).
                                Real-time monitoring dan pharmacy delivery.
                            </p>
                            <div style="color: #2E4A99; font-size: 0.85em;">
                                <strong>Deployment:</strong> 100% Cloud • <strong>Security:</strong> ISO 27001 •
                                <strong>UI:</strong> Modern
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 2em; margin-bottom: 5px;">☁️</div>
                            <div style="color: #FF6B35; font-weight: bold;">Cloud-Native</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Medify (Customizable Platform)</h3>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                        <div>
                            <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">
                                SIMRS dengan source code tersedia untuk customization. Modul lengkap A-Z sesuai standar
                                SNARS. Maintenance 24 jam dan terdaftar PSE Kominfo. Mobile app tersedia dengan PACS &
                                LIS
                                integration.
                            </p>
                            <div style="color: #2E4A99; font-size: 0.85em;">
                                <strong>Deployment:</strong> Flexible • <strong>Support:</strong> 24/7 •
                                <strong>Standard:</strong> SNARS
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 2em; margin-bottom: 5px;">🔧</div>
                            <div style="color: #FF6B35; font-weight: bold;">Customizable</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Kriteria Evaluasi JKB</h3>
                <div class="highlight-box">
                    <div class="grid-3" style="font-size: 0.9em;">
                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; margin-bottom: 5px;">🏥</div>
                            <div style="font-weight: bold; color: #e65100;">Completeness</div>
                            <div style="color: #e65100;">Modul & Fitur</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; margin-bottom: 5px;">🔗</div>
                            <div style="font-weight: bold; color: #e65100;">Integration</div>
                            <div style="color: #e65100;">BPJS & Workflow</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; margin-bottom: 5px;">👥</div>
                            <div style="font-weight: bold; color: #e65100;">Usability</div>
                            <div style="color: #e65100;">User Experience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature Comparison -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Komparasi Fitur Utama</h2>
                <div class="page-number">4</div>
            </div>

            <div class="section">
                <h3 class="section-title">Matriks Perbandingan Lengkap</h3>
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Fitur / Modul</th>
                            <th>SIMRS ICHA</th>
                            <th>Inovamedika</th>
                            <th>AIDO Hospital</th>
                            <th>Medify</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Pendaftaran & IGD</strong></td>
                            <td>✓ Excellent + Antrian</td>
                            <td>✓ Good + Mobile</td>
                            <td>✓ Advanced Cloud</td>
                            <td>✓ Complete</td>
                        </tr>
                        <tr>
                            <td><strong>EMR & SOAP</strong></td>
                            <td>✓ Template Spesialis</td>
                            <td>✓ HL7 Standard</td>
                            <td>✓ Clinical Tools</td>
                            <td>✓ Comprehensive</td>
                        </tr>
                        <tr>
                            <td><strong>Lab & Radiologi</strong></td>
                            <td>✓ Terintegrasi Penuh</td>
                            <td>✓ DICOM Support</td>
                            <td>✓ PACS Ready</td>
                            <td>✓ LIS Integration</td>
                        </tr>
                        <tr>
                            <td><strong>Farmasi & Inventory</strong></td>
                            <td>✓ Real-time + Ekspired</td>
                            <td>✓ E-Prescription</td>
                            <td>✓ Delivery Service</td>
                            <td>✓ Stock Management</td>
                        </tr>
                        <tr>
                            <td><strong>Bridging BPJS</strong></td>
                            <td>✓ Complete (V-claim, INA-CBG)</td>
                            <td>✓ V-claim + e-claim</td>
                            <td>✓ Full Integration</td>
                            <td>✓ BPJS Support</td>
                        </tr>
                        <tr>
                            <td><strong>Mobile Application</strong></td>
                            <td>✓ Patient + Website</td>
                            <td>✓ Patient + Doctor Apps</td>
                            <td>△ Web-based Only</td>
                            <td>✓ Mobile Available</td>
                        </tr>
                        <tr>
                            <td><strong>Akreditasi Support</strong></td>
                            <td>✓ SISMADAK Dedicated</td>
                            <td>△ Standard Docs</td>
                            <td>△ Basic Support</td>
                            <td>✓ SNARS Compliant</td>
                        </tr>
                        <tr>
                            <td><strong>Cloud/File Sharing</strong></td>
                            <td>✓ Nextcloud Built-in</td>
                            <td>△ Optional Feature</td>
                            <td>✓ Full Cloud Native</td>
                            <td>△ Limited Cloud</td>
                        </tr>
                        <tr>
                            <td><strong>Customization</strong></td>
                            <td>△ Template-based</td>
                            <td>✓ Full Source Code</td>
                            <td>✗ Limited Custom</td>
                            <td>✓ Source Available</td>
                        </tr>
                        <tr>
                            <td><strong>Sistem Nasional Bridge</strong></td>
                            <td>✓ SISRUTE, SITT, LUPIS+</td>
                            <td>△ SATUSEHAT Focus</td>
                            <td>△ Basic Bridge</td>
                            <td>△ Standard Bridge</td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top: 10px; font-size: 0.85em; color: #666;">
                    <strong>Legend:</strong> ✓ = Excellent/Full Support • △ = Partial/Limited • ✗ = Not Available
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Skor Evaluasi JKB Comprehensive</h3>
                <div class="grid-4">
                    <div
                        style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #28a745;">
                        <h4 style="color: #2E4A99; margin-bottom: 8px;">SIMRS ICHA</h4>
                        <div style="font-size: 2em; font-weight: bold; color: #28a745;">96</div>
                        <div style="font-size: 0.9em; color: #666;">Score /100</div>
                    </div>
                    <div
                        style="background: #f8f9fa; padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #17a2b8;">
                        <h4 style="color: #2E4A99; margin-bottom: 8px;">Inovamedika</h4>
                        <div style="font-size: 2em; font-weight: bold; color: #17a2b8;">89</div>
                        <div style="font-size: 0.9em; color: #666;">Score /100</div>
                    </div>
                    <div
                        style="background: #f8f9fa; padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #ffc107;">
                        <h4 style="color: #2E4A99; margin-bottom: 8px;">AIDO Hospital</h4>
                        <div style="font-size: 2em; font-weight: bold; color: #ffc107;">84</div>
                        <div style="font-size: 0.9em; color: #666;">Score /100</div>
                    </div>
                    <div
                        style="background: #f8f9fa; padding: 15px; border-radius: 8px; text-align: center; border-left: 4px solid #6c757d;">
                        <h4 style="color: #2E4A99; margin-bottom: 8px;">Medify</h4>
                        <div style="font-size: 2em; font-weight: bold; color: #6c757d;">86</div>
                        <div style="font-size: 0.9em; color: #666;">Score /100</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Keunggulan Spesifik SIMRS ICHA</h3>
                <div class="success-box">
                    <div class="grid-2">
                        <div>
                            <h4 style="color: #2e7d32; margin-bottom: 10px;">🏆 Unique Advantages</h4>
                            <ul style="color: #2e7d32; font-size: 0.9em; list-style: none; padding: 0;">
                                <li style="margin-bottom: 6px;">✓ SISMADAK khusus akreditasi KARS</li>
                                <li style="margin-bottom: 6px;">✓ Nextcloud internal file sharing</li>
                                <li style="margin-bottom: 6px;">✓ 10+ modul terintegrasi sempurna</li>
                            </ul>
                        </div>
                        <div>
                            <h4 style="color: #2e7d32; margin-bottom: 10px;">🔗 Integration Excellence</h4>
                            <ul style="color: #2e7d32; font-size: 0.9em; list-style: none; padding: 0;">
                                <li style="margin-bottom: 6px;">✓ SISRUTE, SITT, SIJARIMAS, LUPIS</li>
                                <li style="margin-bottom: 6px;">✓ Dashboard manajemen real-time</li>
                                <li style="margin-bottom: 6px;">✓ Antrian online & mobile website</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pros and Cons Analysis -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Analisis Kelebihan & Kekurangan</h2>
                <div class="page-number">5</div>
            </div>

            <div class="section">
                <h3 class="section-title">SIMRS ICHA (Comprehensive) - RECOMMENDED</h3>
                <div class="pros-cons">
                    <div class="pros" style="border-left-color: #28a745;">
                        <h4 style="color: #28a745;">✅ Kelebihan Utama</h4>
                        <ul style="color: #28a745;">
                            <li>10+ modul terintegrasi lengkap & seamless</li>
                            <li>SISMADAK khusus akreditasi KARS</li>
                            <li>Bridging terlengkap (BPJS + sistem nasional)</li>
                            <li>Nextcloud untuk file sharing internal RS</li>
                            <li>Mobile app pasien & website terintegrasi</li>
                            <li>Dashboard real-time untuk manajemen</li>
                            <li>Antrian online & cetak tiket otomatis</li>
                        </ul>
                    </div>
                    <div class="cons">
                        <h4>❌ Area Improvement</h4>
                        <ul>
                            <li>Source code access terbatas</li>
                            <li>Kompleksitas training tinggi</li>
                            <li>Membutuhkan change management intensif</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Inovamedika iHospital (Open Source)</h3>
                <div class="pros-cons">
                    <div class="pros">
                        <h4>✅ Kelebihan</h4>
                        <ul>
                            <li>Akses penuh source code (open source)</li>
                            <li>Customization unlimited</li>
                            <li>Standar SATUSEHAT (HL7, DICOM)</li>
                            <li>Mobile app untuk dokter & pasien</li>
                            <li>UI modern dan user-friendly</li>
                            <li>Community support yang aktif</li>
                        </ul>
                    </div>
                    <div class="cons">
                        <h4>❌ Kekurangan</h4>
                        <ul>
                            <li>Butuh expertise IT tinggi untuk maintain</li>
                            <li>Support tergantung pada vendor</li>
                            <li>Implementasi kompleks & time-consuming</li>
                            <li>Modul akreditasi masih standar</li>
                            <li>Integration effort tinggi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">AIDO Hospital (Cloud-Native)</h3>
                <div class="pros-cons">
                    <div class="pros">
                        <h4>✅ Kelebihan</h4>
                        <ul>
                            <li>100% cloud, zero server lokal</li>
                            <li>Sertifikasi ISO 27001 keamanan</li>
                            <li>UI modern & responsif</li>
                            <li>Clinical Assessment Tools lengkap</li>
                            <li>Real-time monitoring built-in</li>
                            <li>Pharmacy delivery service</li>
                        </ul>
                    </div>
                    <div class="cons">
                        <h4>❌ Kekurangan</h4>
                        <ul>
                            <li>100% ketergantungan internet</li>
                            <li>Customization sangat terbatas</li>
                            <li>Biaya recurring cloud tinggi</li>
                            <li>Data sovereignty concerns</li>
                            <li>Vendor lock-in risk</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Medify (Customizable Platform)</h3>
                <div class="pros-cons">
                    <div class="pros">
                        <h4>✅ Kelebihan</h4>
                        <ul>
                            <li>Source code tersedia untuk custom</li>
                            <li>Maintenance support 24 jam</li>
                            <li>Modul A-Z sangat lengkap</li>
                            <li>SNARS compliance ready</li>
                            <li>PSE Kominfo registered</li>
                            <li>PACS & LIS integration</li>
                        </ul>
                    </div>
                    <div class="cons">
                        <h4>❌ Kekurangan</h4>
                        <ul>
                            <li>User interface kurang modern</li>
                            <li>Integration complexity tinggi</li>
                            <li>Dokumentasi masih terbatas</li>
                            <li>Learning curve yang steep</li>
                            <li>Performance optimization manual</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Workflow Compatibility -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Kesesuaian dengan Alur Rumah Sakit</h2>
                <div class="page-number">6</div>
            </div>

            <div class="section">
                <h3 class="section-title">Mapping Workflow Rumah Sakit Indonesia</h3>
                <p style="margin-bottom: 20px;">
                    Evaluasi kesesuaian setiap sistem dengan alur operasional standar rumah sakit Indonesia,
                    termasuk compliance BPJS dan regulasi Kemenkes:
                </p>
            </div>

            <div class="section">
                <h3 class="section-title">Fase 1: Pendaftaran & Admisi Pasien</h3>
                <div class="flowchart-match">
                    <div class="match-item">
                        <div class="match-icon match-high">SIMRS ICHA</div>
                        <span>Pendaftaran terintegrasi penuh dengan BPJS bridging otomatis, antrian online + cetak
                            tiket</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-high">Inovamedika</div>
                        <span>Modern registration dengan mobile app dan SATUSEHAT integration standar</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">AIDO Hospital</div>
                        <span>Cloud-based registration dengan Clinical Assessment Tools yang advanced</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">Medify</div>
                        <span>Registration standar dengan SNARS compliance, butuh customization</span>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Fase 2: Pelayanan Medis & EMR</h3>
                <div class="flowchart-match">
                    <div class="match-item">
                        <div class="match-icon match-high">SIMRS ICHA</div>
                        <span>EMR template spesialis lengkap, SOAP terintegrasi penuh dengan lab & farmasi</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-high">Inovamedika</div>
                        <span>HL7 compliant EMR dengan DICOM support dan mobile access untuk dokter</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-high">AIDO Hospital</div>
                        <span>Clinical Tools advanced (Glasgow Coma, Morse Fall) dengan real-time monitoring</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">Medify</div>
                        <span>EMR comprehensive dengan PACS/LIS integration, UI perlu improvement</span>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Fase 3: Penunjang Medis (Lab, Radiologi, Farmasi)</h3>
                <div class="flowchart-match">
                    <div class="match-item">
                        <div class="match-icon match-high">SIMRS ICHA</div>
                        <span>Integrasi seamless lab-radiologi-farmasi dengan real-time inventory & expired
                            tracking</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">Inovamedika</div>
                        <span>DICOM support baik, e-prescription tersedia, butuh setup integration complex</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">AIDO Hospital</div>
                        <span>PACS ready dengan pharmacy delivery service, tergantung koneksi internet</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">Medify</div>
                        <span>LIS integration tersedia, stock management manual, perlu optimization</span>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Fase 4: Billing & Discharge</h3>
                <div class="flowchart-match">
                    <div class="match-item">
                        <div class="match-icon match-high">SIMRS ICHA</div>
                        <span>V-claim & INA-CBG otomatis, bridging SISRUTE/SITT/LUPIS lengkap untuk reporting</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">Inovamedika</div>
                        <span>V-claim & e-claim support, SATUSEHAT focus tapi bridging lain terbatas</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-medium">AIDO Hospital</div>
                        <span>Full BPJS integration tersedia, reporting basic, cloud dependency tinggi</span>
                    </div>
                    <div class="match-item">
                        <div class="match-icon match-low">Medify</div>
                        <span>BPJS support ada, bridging sistem nasional lain perlu custom development</span>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Overall Workflow Compatibility Score</h3>
                <div class="recommendation-box">
                    <h3 class="recommendation-title">🎯 Ranking Kesesuaian Workflow RS Indonesia</h3>
                    <div class="grid-2">
                        <div class="recommended-system" style="border-left: 4px solid #28a745;">
                            <div class="system-name" style="color: #28a745;">1. SIMRS ICHA + JKB</div>
                            <div class="match-percentage" style="background: #28a745;">95% Workflow Match</div>
                            <p style="font-size: 0.9em; color: #666;">
                                Seamless integration dengan semua fase operasional RS Indonesia.
                                Bridging terlengkap + pengelolaan JKB memastikan implementasi sukses.
                            </p>
                        </div>
                        <div class="recommended-system" style="border-left: 4px solid #17a2b8;">
                            <div class="system-name" style="color: #17a2b8;">2. Inovamedika iHospital</div>
                            <div class="match-percentage" style="background: #17a2b8;">88% Workflow Match</div>
                            <p style="font-size: 0.9em; color: #666;">
                                Modern solution dengan HL7/DICOM standard. Butuh effort tinggi
                                untuk implementasi dan customization workflow RS.
                            </p>
                        </div>
                    </div>
                    <div class="grid-2" style="margin-top: 15px;">
                        <div class="recommended-system" style="border-left: 4px solid #ffc107;">
                            <div class="system-name" style="color: #ffc107;">3. Medify</div>
                            <div class="match-percentage" style="background: #ffc107;">82% Workflow Match</div>
                            <p style="font-size: 0.9em; color: #666;">
                                Modul lengkap tapi UI/UX perlu improvement. Integration effort
                                tinggi untuk workflow optimization.
                            </p>
                        </div>
                        <div class="recommended-system" style="border-left: 4px solid #fd7e14;">
                            <div class="system-name" style="color: #fd7e14;">4. AIDO Hospital</div>
                            <div class="match-percentage" style="background: #fd7e14;">79% Workflow Match</div>
                            <p style="font-size: 0.9em; color: #666;">
                                Cloud-native excellent tapi 100% dependency internet.
                                Customization terbatas untuk workflow spesifik RS.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cta-section">
                <h3 class="cta-title">SIMRS ICHA: Perfect Fit untuk Workflow RS Indonesia</h3>
                <p style="margin-bottom: 20px; opacity: 0.9;">
                    95% compatibility dengan dukungan JKB untuk seamless implementation
                </p>
            </div>
        </div>

        <!-- Recommendation & JKB Management -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Rekomendasi Sistem & Pengelolaan JKB</h2>
                <div class="page-number">7</div>
            </div>

            <div class="section">
                <h3 class="section-title">Mengapa SIMRS ICHA + JKB adalah Pilihan Terbaik?</h3>
                <div class="grid-2">
                    <div class="highlight-box">
                        <h4 style="color: #e65100; margin-bottom: 15px;">🔥 Keunggulan SIMRS ICHA</h4>
                        <ul style="list-style: none; padding: 0; color: #e65100; font-size: 0.9em;">
                            <li style="margin-bottom: 8px;">✓ 10+ modul terintegrasi seamless</li>
                            <li style="margin-bottom: 8px;">✓ SISMADAK khusus akreditasi KARS</li>
                            <li style="margin-bottom: 8px;">✓ Bridging terlengkap (BPJS + nasional)</li>
                            <li style="margin-bottom: 8px;">✓ Nextcloud berbagi file terintegrasi</li>
                            <li style="margin-bottom: 8px;">✓ Aplikasi mobile & website terintegrasi</li>
                            <li style="margin-bottom: 8px;">✓ Dashboard manajemen real-time</li>
                            <li style="margin-bottom: 8px;">✓ Antrian online otomatis</li>
                        </ul>
                    </div>
                    <div class="info-box">
                        <h4 style="color: #1976d2; margin-bottom: 15px;">🚀 Nilai Tambah JKB</h4>
                        <ul style="list-style: none; padding: 0; color: #1976d2; font-size: 0.9em;">
                            <li style="margin-bottom: 8px;">✓ 50+ rekam jejak implementasi sukses</li>
                            <li style="margin-bottom: 8px;">✓ Manajemen proyek profesional</li>
                            <li style="margin-bottom: 8px;">✓ Manajemen perubahan & pelatihan intensif</li>
                            <li style="margin-bottom: 8px;">✓ Dukungan & pemeliharaan 24/7</li>
                            <li style="margin-bottom: 8px;">✓ Optimisasi kinerja berkelanjutan</li>
                            <li style="margin-bottom: 8px;">✓ Manajemen hubungan vendor</li>
                            <li style="margin-bottom: 8px;">✓ Dukungan upgrade & scaling masa depan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3 class="section-title">Perbandingan: Dengan vs Tanpa JKB Management</h3>
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>Aspek Implementasi</th>
                            <th>Tanpa JKB</th>
                            <th>Dengan Manajemen JKB</th>
                            <th>Peningkatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tingkat Keberhasilan</strong></td>
                            <td>60-70% (rata-rata industri)</td>
                            <td>99% (rekam jejak JKB)</td>
                            <td style="color: #28a745;"><strong>+40%</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Implementasi</strong></td>
                            <td>8-12 bulan</td>
                            <td>4-6 bulan</td>
                            <td style="color: #28a745;"><strong>50% lebih cepat</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Tingkat Adopsi Pengguna</strong></td>
                            <td>40-60%</td>
                            <td>85-95%</td>
                            <td style="color: #28a745;"><strong>+45%</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Masalah Pasca-Peluncuran</strong></td>
                            <td>30-50 masalah/bulan</td>
                            <td>5-10 masalah/bulan</td>
                            <td style="color: #28a745;"><strong>Pengurangan 80%</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Efektivitas Pelatihan</strong></td>
                            <td>Pelatihan dasar vendor</td>
                            <td>Manajemen perubahan komprehensif</td>
                            <td style="color: #28a745;"><strong>3x lebih baik</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Dukungan Jangka Panjang</strong></td>
                            <td>Ketergantungan vendor</td>
                            <td>Layanan terkelola JKB 24/7</td>
                            <td style="color: #28a745;"><strong>Terjamin</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Implementation & Support -->
        <div class="page content-page">
            <div class="page-header">
                <h2 class="page-title">Implementasi dan Support JKB</h2>
                <div class="page-number">8</div>
            </div>

            <div class="section">
                <h3 class="section-title">Action Plan Implementasi SIMRS ICHA dengan JKB (Juli 2025 - Januari 2026)</h3>
                
                <!-- Timeline Header -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 5px; align-items: center;">
                        <div style="font-weight: bold; color: #2E4A99;">Fase Implementasi</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Jul 2025</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Ags 2025</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Sep 2025</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Okt 2025</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Nov 2025</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Des 2025</div>
                        <div style="text-align: center; font-weight: bold; color: #2E4A99; font-size: 0.9em;">Jan 2026</div>
                    </div>
                </div>

                <!-- Project Phases with Gantt Chart Style -->
                <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                    
                    <!-- Phase 1: Project Initiation -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #e3f2fd; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #1976d2; font-size: 0.9em;">Project Initiation</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Kickoff & Planning</div>
                        </div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #1976d2; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #1976d2; font-weight: bold; background: white; padding: 0 4px;">Week 1-2</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 2: Requirement Analysis -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #fff3e0; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #f57c00; font-size: 0.9em;">Requirement Analysis</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Business Process Mapping</div>
                        </div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 50%; height: 8px; background: #f57c00; border-radius: 4px; margin-left: 50%;"></div>
                            <div style="position: absolute; top: 5px; right: 25%; transform: translateX(50%); font-size: 0.7em; color: #f57c00; font-weight: bold; background: white; padding: 0 4px;">Week 3-4</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 3: System Preparation -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #fff3e0; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #f57c00; font-size: 0.9em;">System Preparation</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Server Setup & Installation</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #f57c00; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #f57c00; font-weight: bold; background: white; padding: 0 4px;">Week 1-2</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 4: Core Configuration -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #fff3e0; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #f57c00; font-size: 0.9em;">Core Configuration</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Master Data & Templates</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 50%; height: 8px; background: #f57c00; border-radius: 4px; margin-left: 50%;"></div>
                            <div style="position: absolute; top: 5px; right: 25%; transform: translateX(50%); font-size: 0.7em; color: #f57c00; font-weight: bold; background: white; padding: 0 4px;">Week 3-4</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 5: Integration Setup -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #f3e5f5; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #8e24aa; font-size: 0.9em;">Integration Setup</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">BPJS & System Bridging</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #8e24aa; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #8e24aa; font-weight: bold; background: white; padding: 0 4px;">Week 1-2</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 6: Module Testing -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #f3e5f5; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #8e24aa; font-size: 0.9em;">Module Testing</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">End-to-End Testing</div>
                        </div>
                        <div class="border-right: 1px solid #ddd;"></div>
                        <div class="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 50%; height: 8px; background: #8e24aa; border-radius: 4px; margin-left: 50%;"></div>
                            <div style="position: absolute; top: 5px; right: 25%; transform: translateX(50%); font-size: 0.7em; color: #8e24aa; font-weight: bold; background: white; padding: 0 4px;">Week 3-4</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 7: User Training Phase 1 -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #e8f5e8; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #28a745; font-size: 0.9em;">User Training Phase 1</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Management & Super User</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #28a745; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #28a745; font-weight: bold; background: white; padding: 0 4px;">Week 1-2</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 8: User Training Phase 2 -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #e8f5e8; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #28a745; font-size: 0.9em;">User Training Phase 2</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">All Departments</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 50%; height: 8px; background: #28a745; border-radius: 4px; margin-left: 50%;"></div>
                            <div style="position: absolute; top: 5px; right: 25%; transform: translateX(50%); font-size: 0.7em; color: #28a745; font-weight: bold; background: white; padding: 0 4px;">Week 3-4</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 9: Pilot Implementation -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #e8f5e8; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #28a745; font-size: 0.9em;">Pilot Implementation</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Soft Launch & Testing</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #28a745; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #28a745; font-weight: bold; background: white; padding: 0 4px;">Week 1-2</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 10: Phase Rollout -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #e8f5e8; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #28a745; font-size: 0.9em;">Phase Rollout</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Gradual Department Rollout</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 50%; height: 8px; background: #28a745; border-radius: 4px; margin-left: 50%;"></div>
                            <div style="position: absolute; top: 5px; right: 25%; transform: translateX(50%); font-size: 0.7em; color: #28a745; font-weight: bold; background: white; padding: 0 4px;">Week 3-4</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div></div>
                    </div>

                    <!-- Phase 11: Full Go-Live -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #c8e6c9; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #2e7d32; font-size: 0.9em;">Full Go-Live</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Complete System Activation</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #2e7d32; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #2e7d32; font-weight: bold; background: white; padding: 0 4px;">Week 1-2</div>
                        </div>
                        <div></div>
                    </div>

                    <!-- Phase 12: Stabilization -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; border-bottom: 1px solid #ddd; min-height: 60px;">
                        <div style="padding: 15px; background: #c8e6c9; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #2e7d32; font-size: 0.9em;">Stabilization</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Post Go-Live Support</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; border-right: 1px solid #ddd; display: flex; align-items: center; position: relative;">
                            <div style="width: 50%; height: 8px; background: #2e7d32; border-radius: 4px; margin-left: 50%;"></div>
                            <div style="position: absolute; top: 5px; right: 25%; transform: translateX(50%); font-size: 0.7em; color: #2e7d32; font-weight: bold; background: white; padding: 0 4px;">Week 3-4</div>
                        </div>
                        <div></div>
                    </div>

                    <!-- Phase 13: Project Closure -->
                    <div style="display: grid; grid-template-columns: 300px repeat(7, 1fr); gap: 0; min-height: 60px;">
                        <div style="padding: 15px; background: #c8e6c9; border-right: 1px solid #ddd; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-weight: bold; color: #2e7d32; font-size: 0.9em;">Project Closure</div>
                            <div style="font-size: 0.8em; color: #666; margin-top: 3px;">Final Optimization & Handover</div>
                        </div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="border-right: 1px solid #ddd;"></div>
                        <div style="padding: 10px; display: flex; align-items: center; position: relative;">
                            <div style="width: 100%; height: 8px; background: #2e7d32; border-radius: 4px;"></div>
                            <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.7em; color: #2e7d32; font-weight: bold; background: white; padding: 0 4px;">Week 1-4</div>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <div style="font-weight: bold; color: #2E4A99; margin-bottom: 10px;">Legend:</div>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; font-size: 0.85em;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 20px; height: 8px; background: #1976d2; border-radius: 4px; margin-right: 8px;"></div>
                            <span>Project Setup</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <div style="width: 20px; height: 8px; background: #f57c00; border-radius: 4px; margin-right: 8px;"></div>
                            <span>System Development</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <div style="width: 20px; height: 8px; background: #8e24aa; border-radius: 4px; margin-right: 8px;"></div>
                            <span>Integration & Testing</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <div style="width: 20px; height: 8px; background: #28a745; border-radius: 4px; margin-right: 8px;"></div>
                            <span>Training & Go-Live</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>

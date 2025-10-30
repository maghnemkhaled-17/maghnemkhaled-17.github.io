<?php
// index.php
require_once 'db.php';

// Générer le prochain numéro
$stmt = $pdo->query("SELECT MAX(number) as max_num FROM courriers WHERE number LIKE 'D-%'");
$last_out = $stmt->fetch();
$next_out = 'D-' . (intval(substr($last_out['max_num'] ?? 'D-1000', 2)) + 1);

$stmt = $pdo->query("SELECT MAX(number) as max_num FROM courriers WHERE number LIKE 'A-%'");
$last_in = $stmt->fetch();
$next_in = 'A-' . (intval(substr($last_in['max_num'] ?? 'A-2000', 2)) + 1);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gestion des courriers — Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app">
        <header>
            <div class="brand">
                <div class="logo">GC</div>
                <div>
                    <div class="title">Gestionnaire de courriers</div>
                    <div class="muted">Application web avec base de données</div>
                </div>
            </div>
            <nav>
                <button class="nav-btn active" data-target="out">Courriers départ</button>
                <button class="nav-btn" data-target="in">Courriers arrivé</button>
                <button class="nav-btn" data-target="history">Historique</button>
            </nav>
        </header>

        <main>
            <!-- OUTGOING -->
            <section id="out" class="card fade show">
                <h3>Courrier de départ</h3>
                <form id="form-out">
                    <div class="row">
                        <div style="flex:1">
                            <label>Date et heure</label>
                            <input type="datetime-local" id="out-datetime" required />
                        </div>
                        <div class="small">
                            <label>Numéro de courrier</label>
                            <input type="text" id="out-number" value="<?php echo $next_out; ?>" readonly />
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>Destinataire</label>
                            <select id="out-to" required></select>
                        </div>
                        <div style="flex:1">
                            <label>En copie (optionnel)</label>
                            <select id="out-cc" multiple></select>
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>Division / direction</label>
                            <select id="out-division" required></select>
                        </div>
                        <div style="flex:1">
                            <label>Département</label>
                            <select id="out-dept"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>Objet</label>
                            <input type="text" id="out-subject" required />
                        </div>
                        <div style="width:220px">
                            <label>Pièce jointe (PDF)</label>
                            <input type="file" id="out-file" accept="application/pdf" />
                        </div>
                    </div>

                    <details style="margin-bottom:12px;background:transparent;padding:10px;border-radius:8px;border:1px dashed rgba(255,255,255,0.02)">
                        <summary style="cursor:pointer;color:var(--muted)">Classement (dossier / sous-dossier)</summary>
                        <div style="margin-top:10px">
                            <div class="row">
                                <div style="flex:1">
                                    <label>Dossier</label>
                                    <input type="text" id="out-dossier" placeholder="Ex: RH, Finances..." />
                                </div>
                                <div style="flex:1">
                                    <label>Sous-dossier</label>
                                    <input type="text" id="out-sous" placeholder="Ex: Contrats, Factures..." />
                                </div>
                            </div>
                        </div>
                    </details>

                    <div class="actions">
                        <button class="btn" type="submit">Enregistrer</button>
                        <button class="btn secondary" type="button" id="out-print">Imprimer</button>
                        <div class="muted right" id="out-status"></div>
                    </div>
                </form>
            </section>

            <!-- INCOMING -->
            <section id="in" class="card fade" style="display:none">
                <h3>Courrier d'arrivée</h3>
                <form id="form-in">
                    <div class="row">
                        <div style="flex:1">
                            <label>Date et heure</label>
                            <input type="datetime-local" id="in-datetime" required />
                        </div>
                        <div class="small">
                            <label>Numéro de courrier</label>
                            <input type="text" id="in-number" value="<?php echo $next_in; ?>" readonly />
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>Référence (interne)</label>
                            <input type="text" id="in-ref" />
                        </div>
                        <div style="flex:1">
                            <label>Expéditeur</label>
                            <select id="in-from" required></select>
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>Division / direction</label>
                            <select id="in-division" required></select>
                        </div>
                        <div style="flex:1">
                            <label>Département</label>
                            <select id="in-dept"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div style="flex:1">
                            <label>Objet</label>
                            <input type="text" id="in-subject" required />
                        </div>
                        <div style="width:220px">
                            <label>Pièce jointe (PDF)</label>
                            <input type="file" id="in-file" accept="application/pdf" />
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn" type="submit">Enregistrer</button>
                        <button class="btn secondary" type="button" id="in-print">Imprimer</button>
                        <div class="muted right" id="in-status"></div>
                    </div>
                </form>
            </section>

            <!-- HISTORY -->
            <section id="history" class="card fade" style="display:none">
                <h3>Historique des courriers</h3>
                <div style="overflow:auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Date & heure</th>
                                <th>Type</th>
                                <th>Destinataire / Expéditeur</th>
                                <th>Objet</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="history-body"></tbody>
                    </table>
                </div>
            </section>
        </main>

        <footer>Application web avec base de données MySQL</footer>
    </div>

    <script>
        // Données de référence
        const SAMPLE_USERS = [
            'Service RH', 'Direction Générale', 'Comptabilité', 'Service Juridique', 'Logistique', 'Client Externe'
        ];
        const SAMPLE_DIVS = ['Direction générale','Direction financière','Direction technique','Direction commerciale'];
        const SAMPLE_DEPTS = ['Administration','Paie','Achats','Maintenance','Marketing'];

        // Utilitaires DOM
        const $ = s => document.querySelector(s);
        const $all = s => document.querySelectorAll(s);

        // Remplir les sélections
        function populate() {
            const selects = {
                'out-to': SAMPLE_USERS,
                'out-cc': SAMPLE_USERS,
                'in-from': SAMPLE_USERS,
                'out-division': SAMPLE_DIVS,
                'in-division': SAMPLE_DIVS,
                'out-dept': SAMPLE_DEPTS,
                'in-dept': SAMPLE_DEPTS
            };

            Object.entries(selects).forEach(([id, options]) => {
                const select = $(`#${id}`);
                select.innerHTML = '';
                options.forEach(opt => {
                    const option = new Option(opt, opt);
                    select.add(option);
                });
            });
        }

        // Date/heure locale
        function nowLocalDatetimeInput() {
            const d = new Date();
            const pad = n => String(n).padStart(2, '0');
            return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
        }

        // Charger l'historique
        async function loadHistory() {
            try {
                const response = await fetch('api.php');
                const mails = await response.json();
                const tbody = $('#history-body');
                
                if (!mails.length) {
                    tbody.innerHTML = '<tr><td colspan="6" class="muted">Aucun courrier enregistré.</td></tr>';
                    return;
                }

                tbody.innerHTML = '';
                mails.forEach(mail => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${mail.number}</td>
                        <td>${new Date(mail.datetime).toLocaleString()}</td>
                        <td><span class="tag ${mail.type==='départ'?'out':'in'}">${mail.type}</span></td>
                        <td>${mail.destinataire || mail.expediteur || ''}</td>
                        <td>${mail.objet || ''}</td>
                        <td>
                            <button class="nav-btn" onclick="printMail(${mail.id})">Imprimer</button>
                            <button class="nav-btn" style="background:#ff4444" onclick="deleteMail(${mail.id})">Supprimer</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } catch (e) {
                console.error('Erreur chargement historique:', e);
            }
        }

        // Sauvegarder un courrier
        async function saveMail(mail) {
            try {
                const response = await fetch('api.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(mail)
                });
                
                if (response.ok) {
                    loadHistory();
                    return true;
                }
            } catch (e) {
                console.error('Erreur sauvegarde:', e);
            }
            return false;
        }

        // Supprimer un courrier
        async function deleteMail(id) {
            if (confirm('Supprimer ce courrier ?')) {
                await fetch('api.php', {
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({id})
                });
                loadHistory();
            }
        }

        // Imprimer un courrier
        function printMail(id) {
            // Récupérer les détails du courrier pour impression
            fetch('api.php')
                .then(r => r.json())
                .then(mails => {
                    const mail = mails.find(m => m.id == id);
                    const html = `
                        <html><head><meta charset="utf-8"><title>Impression - ${mail.number}</title>
                        <style>body{font-family:Arial,Helvetica,sans-serif;color:#111;padding:28px}h2{color:#ff7a18}table{width:100%;border-collapse:collapse}td{padding:8px;border-bottom:1px solid #ddd}</style>
                        </head><body>
                        <h2>Courrier ${mail.type} — ${mail.number}</h2>
                        <table>
                            <tr><td><strong>Date & heure</strong></td><td>${new Date(mail.datetime).toLocaleString()}</td></tr>
                            <tr><td><strong>Type</strong></td><td>${mail.type}</td></tr>
                            <tr><td><strong>Destinataire / Expéditeur</strong></td><td>${mail.destinataire || mail.expediteur || ''}</td></tr>
                            <tr><td><strong>Division</strong></td><td>${mail.division || ''}</td></tr>
                            <tr><td><strong>Département</strong></td><td>${mail.departement || ''}</td></tr>
                            <tr><td><strong>Objet</strong></td><td>${mail.objet || ''}</td></tr>
                            <tr><td><strong>Dossier</strong></td><td>${mail.dossier || ''}</td></tr>
                        </table>
                        </body></html>
                    `;
                    const w = window.open('', '_blank');
                    w.document.write(html);
                    w.document.close();
                    setTimeout(() => w.print(), 300);
                });
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            populate();
            
            // Définir dates par défaut
            $('#out-datetime').value = nowLocalDatetimeInput();
            $('#in-datetime').value = nowLocalDatetimeInput();
            
            // Gestion des formulaires
            $('#form-out').addEventListener('submit', async e => {
                e.preventDefault();
                const mail = {
                    type: 'départ',
                    datetime: $('#out-datetime').value,
                    number: $('#out-number').value,
                    to: $('#out-to').value,
                    division: $('#out-division').value,
                    dept: $('#out-dept').value,
                    subject: $('#out-subject').value,
                    dossier: $('#out-dossier').value,
                    sous: $('#out-sous').value
                };
                
                if (await saveMail(mail)) {
                    $('#out-status').textContent = 'Enregistré ✓';
                    setTimeout(() => $('#out-status').textContent = '', 2000);
                    $('#form-out').reset();
                    $('#out-datetime').value = nowLocalDatetimeInput();
                    // Générer nouveau numéro
                    const response = await fetch('api.php');
                    const mails = await response.json();
                    const lastOut = mails.filter(m => m.number.startsWith('D-')).sort((a,b) => b.number.localeCompare(a.number))[0];
                    const nextNum = 'D-' + (parseInt(lastOut?.number.slice(2) || '1000') + 1);
                    $('#out-number').value = nextNum;
                }
            });

            $('#form-in').addEventListener('submit', async e => {
                e.preventDefault();
                const mail = {
                    type: 'arrivé',
                    datetime: $('#in-datetime').value,
                    number: $('#in-number').value,
                    from: $('#in-from').value,
                    ref: $('#in-ref').value,
                    division: $('#in-division').value,
                    dept: $('#in-dept').value,
                    subject: $('#in-subject').value
                };
                
                if (await saveMail(mail)) {
                    $('#in-status').textContent = 'Enregistré ✓';
                    setTimeout(() => $('#in-status').textContent = '', 2000);
                    $('#form-in').reset();
                    $('#in-datetime').value = nowLocalDatetimeInput();
                    // Générer nouveau numéro
                    const response = await fetch('api.php');
                    const mails = await response.json();
                    const lastIn = mails.filter(m => m.number.startsWith('A-')).sort((a,b) => b.number.localeCompare(a.number))[0];
                    const nextNum = 'A-' + (parseInt(lastIn?.number.slice(2) || '2000') + 1);
                    $('#in-number').value = nextNum;
                }
            });

            // Navigation
            $all('.nav-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    $all('.nav-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const target = btn.dataset.target;
                    ['out', 'in', 'history'].forEach(id => {
                        const section = $(`#${id}`);
                        if (id === target) {
                            section.style.display = 'block';
                            section.classList.add('show');
                        } else {
                            section.style.display = 'none';
                            section.classList.remove('show');
                        }
                    });
                    
                    if (target === 'history') loadHistory();
                });
            });

            // Chargement initial
            loadHistory();
        });
    </script>
</body>
</html>
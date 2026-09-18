(function () {
    const KEY = 'gestionMambembaData';
    const VERSION = 2;

    function defaults() {
        return {
            version: VERSION,
            professeurs: [
                { id: 1, nom: 'MBALA', postnom: 'Kalonda', prenom: 'Dieudonné', matiere: 'Mathématiques', telephone: '+243 820 000 001' },
                { id: 2, nom: 'TSHIBANGU', postnom: 'Mukendi', prenom: 'Esther', matiere: 'Français', telephone: '+243 820 000 002' },
                { id: 3, nom: 'KALONJI', postnom: 'Ntumba', prenom: 'Georges', matiere: 'Physique', telephone: '+243 820 000 003' }
            ],
            salles: [
                { id: 1, nom: 'Salle A1', niveau: '6ème Primaire', capacite: 40, profTitulaireId: 1 },
                { id: 2, nom: 'Salle B2', niveau: '3ème Secondaire', capacite: 45, profTitulaireId: 3 },
                { id: 3, nom: 'Salle C3', niveau: '2ème Secondaire', capacite: 45, profTitulaireId: null }
            ],
            eleves: [
                { id: 1, matricule: 'MB-2025-001', nom: 'KABEYA Jean-Marc', sexe: 'M', classe: '6ème Primaire', contact: '+243 810 000 001', statut: 'Inscrit', salleId: 1 },
                { id: 2, matricule: 'MB-2025-002', nom: 'ILUNGA Grâce', sexe: 'F', classe: '3ème Secondaire', contact: '+243 890 000 002', statut: 'En attente', salleId: 2 },
                { id: 3, matricule: 'MB-2025-003', nom: 'MUKENDI Patrick', sexe: 'M', classe: '2ème Secondaire', contact: '+243 991 000 003', statut: 'Inscrit', salleId: 3 },
                { id: 4, matricule: 'MB-2025-004', nom: 'KALALA Naomi', sexe: 'F', classe: '6ème Primaire', contact: '+243 810 000 004', statut: 'Inscrit', salleId: 1 },
                { id: 5, matricule: 'MB-2025-005', nom: 'MUTOMBO Emmanuel', sexe: 'M', classe: '6ème Primaire', contact: '+243 810 000 005', statut: 'Inscrit', salleId: 1 },
                { id: 6, matricule: 'MB-2025-006', nom: 'LUKUSA Christelle', sexe: 'F', classe: '6ème Primaire', contact: '+243 810 000 006', statut: 'En attente', salleId: 1 },
                { id: 7, matricule: 'MB-2025-007', nom: 'TSHIMANGA Josué', sexe: 'M', classe: '3ème Secondaire', contact: '+243 890 000 007', statut: 'Inscrit', salleId: 2 },
                { id: 8, matricule: 'MB-2025-008', nom: 'NDALA Adèle', sexe: 'F', classe: '3ème Secondaire', contact: '+243 890 000 008', statut: 'Inscrit', salleId: 2 },
                { id: 9, matricule: 'MB-2025-009', nom: 'KABANGA Fiston', sexe: 'M', classe: '2ème Secondaire', contact: '+243 991 000 009', statut: 'Inscrit', salleId: 3 },
                { id: 10, matricule: 'MB-2025-010', nom: 'BWANGA Clarisse', sexe: 'F', classe: '2ème Secondaire', contact: '+243 991 000 010', statut: 'En attente', salleId: 3 },
                { id: 11, matricule: 'MB-2025-011', nom: 'MPOYI Daniel', sexe: 'M', classe: '2ème Secondaire', contact: '+243 991 000 011', statut: 'Inscrit', salleId: 3 }
            ]
        };
    }

    function load() {
        let data = null;
        try {
            data = JSON.parse(localStorage.getItem(KEY));
        } catch (e) {
            data = null;
        }
        if (!data || !data.professeurs || !data.salles || !data.eleves || data.version !== VERSION) {
            data = defaults();
            save(data);
        }
        return data;
    }

    function save(data) {
        localStorage.setItem(KEY, JSON.stringify(data));
    }

    function nextId(arr) {
        return arr.reduce(function (m, i) { return Math.max(m, i.id); }, 0) + 1;
    }

    function nomCompletProf(p) {
        return [p.nom, p.postnom, p.prenom].filter(Boolean).join(' ');
    }

    function nomSalle(data, id) {
        const s = data.salles.find(function (s) { return s.id === id; });
        return s ? s.nom : '—';
    }

    function salleTitulaireOf(data, profId) {
        const s = data.salles.find(function (s) { return s.profTitulaireId === profId; });
        return s ? s.nom : '—';
    }

    function profTitulaireOf(data, salleId) {
        const salle = data.salles.find(function (s) { return s.id === salleId; });
        if (!salle || !salle.profTitulaireId) return '—';
        const p = data.professeurs.find(function (p) { return p.id === salle.profTitulaireId; });
        return p ? nomCompletProf(p) : '—';
    }

    function elevesDeSalle(data, salleId) {
        return data.eleves.filter(function (e) { return e.salleId === salleId; });
    }

    function setSalleTitulaire(data, salleId, profId) {
        data.salles.forEach(function (s) {
            if (s.profTitulaireId === profId && s.id !== salleId) s.profTitulaireId = null;
        });
        const salle = data.salles.find(function (s) { return s.id === salleId; });
        if (salle) salle.profTitulaireId = profId || null;
    }

    window.GM = {
        load: load,
        save: save,
        nextId: nextId,
        nomCompletProf: nomCompletProf,
        nomSalle: nomSalle,
        salleTitulaireOf: salleTitulaireOf,
        profTitulaireOf: profTitulaireOf,
        elevesDeSalle: elevesDeSalle,
        setSalleTitulaire: setSalleTitulaire
    };
})();

export interface CvContact {
  label: string;
  value: string;
  href?: string;
}

export interface CvSkill {
  name: string;
  category: string;
}

export interface CvExperience {
  role: string;
  company: string;
  location: string;
  period: string;
  summary: string;
}

export interface CvEducation {
  title: string;
  place: string;
  period: string;
}

export interface CvAction {
  label: string;
  href: string;
}

export interface CvData {
  name: string;
  title: string;
  location: string;
  summary: string;
  availability: string;
  profileImagePath: string;
  careerStartYear: number;
  contacts: CvContact[];
  primaryActions: CvAction[];
  languages: string[];
  strengths: string[];
  skills: CvSkill[];
  experiences: CvExperience[];
  education: CvEducation[];
  privacyNote: string;
  signatureCity: string;
  signatureDate: string;
}

export const cvData: CvData = {
  name: 'Alessandro Fior',
  title: 'Ingegnere Informatico',
  location: 'Resana (TV), Italia',
  summary:
    "Tecnico programmatore con esperienza su software gestionali, sviluppo web e soluzioni enterprise. L'attenzione e' rivolta soprattutto all'organizzazione dei processi, all'efficientamento operativo e alla qualita' del lavoro quotidiano.",
  availability:
    'Disponibile a spostamenti fino a 40 km dalla residenza, con mezzo proprio o mezzi pubblici, e allo smart working quando richiesto.',
  profileImagePath: '/profile-from-pdf.jpg',
  careerStartYear: 2004,
  contacts: [
    {
      label: 'Telefono',
      value: '+39 333 7385426',
      href: 'tel:+393337385426'
    },
    {
      label: 'Email',
      value: 'alessandro.fior@gmail.com',
      href: 'mailto:alessandro.fior@gmail.com'
    },
    {
      label: 'Indirizzo',
      value: 'Via Piave 23, Resana (TV)'
    },
    {
      label: 'Data di nascita',
      value: '28/03/1981'
    }
  ],
  primaryActions: [
    {
      label: 'Scrivimi',
      href: 'mailto:alessandro.fior@gmail.com'
    },
    {
      label: 'Chiama',
      href: 'tel:+393337385426'
    }
  ],
  languages: ['Italiano: madrelingua', 'Inglese: livello B2'],
  strengths: [
    'Approccio orientato ai processi e al miglioramento continuo',
    'Esperienza trasversale tra desktop, web e contesti enterprise',
    "Precisione, costanza e affidabilita' nell'esecuzione",
    'Interesse per ruoli strutturati in ambito gestionale'
  ],
  skills: [
    { name: 'C#', category: 'Desktop' },
    { name: 'HTML5', category: 'Frontend' },
    { name: 'CSS3', category: 'Frontend' },
    { name: 'JavaScript ES6', category: 'Frontend' },
    { name: 'jQuery', category: 'Frontend' },
    { name: 'Framework web', category: 'Frontend' },
    { name: 'PHP', category: 'Backend' },
    { name: 'ASP.NET MVC', category: 'Backend' },
    { name: 'MySQL', category: 'Database' },
    { name: 'MSSQL', category: 'Database' },
    { name: 'Python base', category: 'Scripting' },
    { name: 'Delphi base', category: 'Desktop' },
    { name: 'Pascal base', category: 'Desktop' }
  ],
  experiences: [
    {
      role: 'Programmatore',
      company: 'LOGO s.p.a.',
      location: 'Borgoricco (PD)',
      period: '02/2024 - in corso',
      summary: 'Sviluppo e manutenzione software in un contesto aziendale orientato ai processi.'
    },
    {
      role: 'Programmatore',
      company: 'TREVIGROUP s.r.l.',
      location: 'Treviso',
      period: '2022 - 2024',
      summary: 'Analisi e realizzazione di applicativi a supporto delle esigenze operative interne.'
    },
    {
      role: 'Full Stack Developer',
      company: 'OPEN SKY s.p.a.',
      location: 'Vicenza',
      period: '2019 - 2020',
      summary: 'Sviluppo full stack per soluzioni web e integrazioni applicative.'
    },
    {
      role: 'Programmatore',
      company: 'ALTEA IN s.r.l.',
      location: 'Padova',
      period: '2016 - 2018',
      summary: "Attivita' di sviluppo su progetti enterprise e strumenti gestionali."
    },
    {
      role: 'Tecnico Automazione CAD PDM/PLM',
      company: 'Nuovamacut s.r.l.',
      location: 'Padova',
      period: '2014 - 2015',
      summary: 'Supporto tecnico e automazione dei flussi CAD con attenzione ai dati di prodotto.'
    },
    {
      role: 'Sviluppatore',
      company: 'Sanmarco Informatica s.p.a.',
      location: 'Grisignano di Zocco',
      period: '2006 - 2012',
      summary: 'Sviluppo software e supporto su piattaforme gestionali in contesti strutturati.'
    },
    {
      role: 'Sviluppatore',
      company: 'IBC SRL',
      location: 'Padova',
      period: '2004 - 2006',
      summary: 'Prime esperienze professionali nello sviluppo applicativo e nella manutenzione software.'
    }
  ],
  education: [
    {
      title: 'Laurea in Ingegneria Informatica',
      place: 'Universita degli Studi di Padova',
      period: '2000 - 2004'
    },
    {
      title: 'Diploma di Ragioneria',
      place: 'I.T.C.G. Martini di Castelfranco Veneto',
      period: '2000 - 2004'
    }
  ],
  privacyNote:
    'Autorizzo il trattamento dei miei dati personali presenti nel CV ai sensi del Decreto Legislativo 30 giugno 2003 n. 196 e dell art. 13 del GDPR (Regolamento UE 2016/679).',
  signatureCity: 'Padova',
  signatureDate: '22 aprile 2026'
};

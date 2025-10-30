// react-app.js

const { useState, useEffect } = React;

/* 🌟 Navbar */
function Navbar() {
  return (
    <header className="navbar">
      <div className="nav-left">
        <img src="img/logo.png" alt="Logo Coin des Saveurs" className="logo-img" />
        <div className="brand">Coin des Saveurs</div>
      </div>

      <nav>
        <ul>
          <li><a href="#home">Accueil</a></li>
          <li><a href="#about">À propos</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#gallery">Galerie</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>
    </header>
  );
}

/* 🎥 Hero Section */
function Hero() {
  return (
    <section id="home" className="hero">
      <video autoPlay muted loop playsInline>
        <source src="" type="video/mp4" />
      </video>
      <div className="hero-card">
        <h1>Coin des Saveurs</h1>
        <p>Où l'élégance rencontre la gourmandise. Nos créations sont faites main, avec des ingrédients choisis.</p>
        <a className="cta" href="#menu">Voir le menu</a>
      </div>
    </section>
  );
}

/* 🍰 About Section */
function About() {
  return (
    <section id="about">
      <div className="section-title container">
        <div style={{ fontFamily: "Times New Roman,serif", fontSize: "2.4rem" }}>À propos</div>
        <small>La passion de la pâtisserie artisanale</small>
      </div>
      <div className="about-wrap">
        <img src="img/homecover2.jpg" alt="Atelier Coin des Saveurs" className="about-img" />
        <div className="about-text">
          <p><strong>Coin des Saveurs</strong> est né d'une passion pour les instants partagés autour d'une pâtisserie raffinée.</p>
          <p style={{ marginTop: "10px" }}>Des recettes travaillées, des ingrédients sélectionnés et une finition soignée : notre promesse est de sublimer vos événements et petits plaisirs.</p>
        </div>
      </div>
    </section>
  );
}

/* 🍮 Menu Section (Dynamic) */
function MenuCard({ img, title, desc, price }) {
  return (
    <article className="menu-card">
      <img src={img} alt={title} />
      <div className="menu-body">
        <h3>{title}</h3>
        <p>{desc}</p>
        <div className="price">{price}</div>
      </div>
    </article>
  );
}

function Menu() {
  const [items, setItems] = useState([
    { img: "img/menu/helloketty.jpg", title: "Birthday Cake", desc: "Gâteau personnalisé, tailles et décors sur demande.", price: "À partir de 30€" },
    { img: "img/menu/Cheesecake.jpg", title: "Cheesecake", desc: "Texture onctueuse et nappage gourmand.", price: "À partir de 18€" },
    { img: "img/menu/cupcakechocolat.jpg", title: "Cupcake", desc: "Petites douceurs à l'unité ou en boîte.", price: "1,50€ / pièce" },
    { img: "img/menu/gateaumarriage.jpg", title: "Wedding Cake", desc: "Pièces artistiques pour célébrer votre jour J.", price: "Sur devis" },
    { img: "img/menu/gateauauchocolat.jpg", title: "Chocolate Cake", desc: "Riche et fondant, pour les amoureux du cacao.", price: "À partir de 22€" },
    { img: "img/menu/Red Velvet Cake.jpg", title: "Red Velvet", desc: "Moelleux et crémeux, finition élégante.", price: "À partir de 24€" },
  ]);

  return (
    <section id="menu">
      <div className="section-title">
        <div style={{ fontFamily: "Times New Roman,serif" }}>Notre Menu</div>
        <small>Des créations pour toutes les occasions</small>
      </div>
      <div className="menu-grid">
        {items.map((item, i) => <MenuCard key={i} {...item} />)}
      </div>
    </section>
  );
}

/* 📸 Gallery */
function Gallery() {
  const images = [
    ["img/gallery/muffins.jpg", "Muffins maison"],
    ["img/gallery/cakepistachou.jpg", "Cake Pistache"],
    ["img/gallery/brownise.JPG", "Brownies chocolat"],
    ["img/gallery/frisierr.JPG", "Fraisier"],
    ["img/gallery/lotus cake.jpg", "Lotus Cake"],
    ["img/gallery/birthdaycake.JPG", "Birthday Cake"],
  ];

  return (
    <section id="gallery">
      <div className="section-title">
        <div style={{ fontFamily: "Times New Roman,serif" }}>Galerie</div>
        <small>Quelques créations récentes</small>
      </div>
      <div className="gallery-grid">
        {images.map(([src, caption], i) => (
          <div className="gallery-item" key={i}>
            <img src={src} alt={caption} />
            <div className="gallery-caption">{caption}</div>
          </div>
        ))}
      </div>
    </section>
  );
}

/* 📩 Contact */
function Contact() {
  const handleSubmit = (e) => {
    e.preventDefault();
    const name = e.target.name.value;
    alert(`Commande reçue — merci ${name} ! Nous vous contactons bientôt.`);
    e.target.reset();
  };

  return (
    <section id="contact">
      <div className="section-title">
        <div style={{ fontFamily: "Times New Roman,serif" }}>Contact</div>
        <small>Commandes & informations</small>
      </div>

      <div className="contact-wrap">
        <div className="form-card">
          <form onSubmit={handleSubmit}>
            <div className="form-row">
              <div className="half"><input type="text" name="name" placeholder="Votre nom" required /></div>
              <div className="half"><input type="email" name="email" placeholder="Votre email" required /></div>
            </div>
            <input type="tel" name="phone" placeholder="Téléphone" required />
            <input type="text" name="item" placeholder="Commande (nom du gâteau ou dessert)" required />
            <textarea name="notes" placeholder="Détails (saveurs, date, décor...)"></textarea>
            <button type="submit">Envoyer la commande</button>
          </form>

          <div className="contact-info">
            <div><strong>Email :</strong> <a href="mailto:coindessaveurs@gmail.com">coindessaveurs@gmail.com</a></div>
            <div><strong>Tél :</strong> <a href="tel:077966862">077966862</a></div>
            <div><a href="https://wa.me/077966862" target="_blank">WhatsApp</a></div>
          </div>
        </div>
      </div>
    </section>
  );
}

/* 🦶 Footer */
function Footer() {
  return (
    <footer>
      <div className="container">
        <div className="muted">
          &copy; {new Date().getFullYear()} Coin des Saveurs — Tous droits réservés.
        </div>
      </div>
    </footer>
  );
}

/* 🌍 Main App */
function App() {
  useEffect(() => {
    // You can still use GSAP here if needed
    if (window.gsap) {
      gsap.from(".hero-card", { y: 40, opacity: 0, duration: 1.0 });
    }
  }, []);

  return (
    <>
      <Navbar />
      <main>
        <Hero />
        <About />
        <Menu />
        <Gallery />
        <Contact />
      </main>
      <Footer />
    </>
  );
}

/* 🧩 Render */
ReactDOM.createRoot(document.getElementById("react-root")).render(<App />);
const { useEffect, useRef, useState } = React;

/* 🎥 Hero Section */
function Hero() {
  const heroRef = useRef();

  useEffect(() => {
    // fade-in on mount
    gsap.from(heroRef.current.querySelector(".hero-card"), {
      y: 60,
      opacity: 0,
      duration: 1.5,
      ease: "power3.out",
    });
  }, []);

  return (
    <section id="home" className="hero" ref={heroRef}>
      <video autoPlay muted loop playsInline>
        <source src="" type="video/mp4" />
      </video>
      <div className="hero-card">
        <h1>Coin des Saveurs</h1>
        <p>Où l'élégance rencontre la gourmandise.</p>
        <a className="cta" href="#menu">Voir le menu</a>
      </div>
    </section>
  );
}

/* 🍰 About Section */
function About() {
  const aboutRef = useRef();

  useEffect(() => {
    gsap.registerPlugin(ScrollTrigger);
    gsap.from(aboutRef.current.querySelector(".about-img"), {
      x: -100,
      opacity: 0,
      duration: 1.2,
      scrollTrigger: {
        trigger: aboutRef.current,
        start: "top 80%",
      },
    });
    gsap.from(aboutRef.current.querySelector(".about-text"), {
      x: 100,
      opacity: 0,
      duration: 1.2,
      delay: 0.3,
      scrollTrigger: {
        trigger: aboutRef.current,
        start: "top 80%",
      },
    });
  }, []);

  return (
    <section id="about" ref={aboutRef}>
      <div className="section-title container">
        <div style={{ fontFamily: "Times New Roman,serif", fontSize: "2.4rem" }}>À propos</div>
        <small>La passion de la pâtisserie artisanale</small>
      </div>
      <div className="about-wrap">
        <img src="img/homecover2.jpg" alt="Atelier Coin des Saveurs" className="about-img" />
        <div className="about-text">
          <p><strong>Coin des Saveurs</strong> est né d'une passion pour les instants partagés.</p>
          <p style={{ marginTop: "10px" }}>Des recettes travaillées, des ingrédients sélectionnés et une finition soignée.</p>
        </div>
      </div>
    </section>
  );
}

/* 🍮 Menu Section */
function Menu() {
  const [items] = useState([
    { img: "img/menu/helloketty.jpg", title: "Birthday Cake", desc: "Gâteau personnalisé.", price: "À partir de 30€" },
    { img: "img/menu/Cheesecake.jpg", title: "Cheesecake", desc: "Texture onctueuse.", price: "À partir de 18€" },
    { img: "img/menu/cupcakechocolat.jpg", title: "Cupcake", desc: "Petites douceurs.", price: "1,50€ / pièce" },
    { img: "img/menu/gateaumarriage.jpg", title: "Wedding Cake", desc: "Pièces artistiques.", price: "Sur devis" },
  ]);

  const menuRef = useRef();

  useEffect(() => {
    gsap.registerPlugin(ScrollTrigger);
    gsap.from(menuRef.current.querySelectorAll(".menu-card"), {
      y: 80,
      opacity: 0,
      duration: 0.9,
      stagger: 0.2,
      scrollTrigger: {
        trigger: menuRef.current,
        start: "top 85%",
      },
    });
  }, []);

  return (
    <section id="menu" ref={menuRef}>
      <div className="section-title">
        <div style={{ fontFamily: "Times New Roman,serif" }}>Notre Menu</div>
        <small>Des créations pour toutes les occasions</small>
      </div>
      <div className="menu-grid">
        {items.map((item, i) => (
          <article className="menu-card" key={i}>
            <img src={item.img} alt={item.title} />
            <div className="menu-body">
              <h3>{item.title}</h3>
              <p>{item.desc}</p>
              <div className="price">{item.price}</div>
            </div>
          </article>
        ))}
      </div>
    </section>
  );
}

/* 📸 Gallery */
function Gallery() {
  const galleryRef = useRef();

  useEffect(() => {
    gsap.registerPlugin(ScrollTrigger);
    gsap.from(galleryRef.current.querySelectorAll(".gallery-item"), {
      scale: 0.9,
      opacity: 0,
      duration: 1.2,
      stagger: 0.15,
      ease: "back.out(1.7)",
      scrollTrigger: {
        trigger: galleryRef.current,
        start: "top 80%",
      },
    });
  }, []);

  const images = [
    ["img/gallery/muffins.jpg", "Muffins maison"],
    ["img/gallery/cakepistachou.jpg", "Cake Pistache"],
    ["img/gallery/brownise.JPG", "Brownies"],
    ["img/gallery/lotus cake.jpg", "Lotus Cake"],
  ];

  return (
    <section id="gallery" ref={galleryRef}>
      <div className="section-title">
        <div style={{ fontFamily: "Times New Roman,serif" }}>Galerie</div>
        <small>Quelques créations récentes</small>
      </div>
      <div className="gallery-grid">
        {images.map(([src, caption], i) => (
          <div className="gallery-item" key={i}>
            <img src={src} alt={caption} />
            <div className="gallery-caption">{caption}</div>
          </div>
        ))}
      </div>
    </section>
  );
}
scrollTrigger: {
  trigger: aboutRef.current,
  start: "top bottom",
  end: "bottom center",
  scrub: true
}

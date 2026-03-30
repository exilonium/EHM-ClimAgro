import { useState } from "react";
import "./Offerings.css";

// we can have as many entries here and they all would be responsive
const offerings = [
  {
    title: "Sustainability Assessment & Reporting",
    paragraph:
      "Supporting ESG disclosure, performance tracking, and SDG-aligned sustainability reporting for organizations and HEIs",
    image:
      "https://ehmconsultancy.co.in/assets/Updated%20-%20Sustainability%20_%20ESG-Cb0Et-k-.png",
    path: "/offerings/sustainability-assessment-reporting",
  },
  {
    title: "Climate Risk Intelligence",
    paragraph:
      "Using AI and analytics to assess risks, model impacts, and guide adaptation strategies.",
    image:
      "https://ehmconsultancy.co.in/assets/Updated%20-%20CLIMATE%20RISK-BCPbJpsB.png",
    path: "/offerings",
  },
  {
    title: "Urban Planning & Management",
    paragraph:
      "Designing data-driven, inclusive, and climate-resilient urban systems through smart planning, water restoration, and sustainable infrastructure",
    image: "https://ehmconsultancy.co.in/offering/4.png",
    path: "/offerings",
  },
];

function Offerings() {
  const [hoveredIndex, setHoveredIndex] = useState(null);

  return (
    <section className="offerings-section">
      {/* Heading */}
      <div className="offerings-heading-wrapper">
        <h2 className="offerings-heading">
          Offerings
          <span className="offerings-underline-primary" />
          <span className="offerings-underline-secondary" />
        </h2>
      </div>

      {/* Grid */}
      <div className="offerings-grid">
        {offerings.map((offering, index) => {
          const isHovered = hoveredIndex === index;
          return (
            <div
              key={offering.title}
              className={`offering-card ${isHovered ? "offering-card--hovered" : ""}`}
              onMouseEnter={() => setHoveredIndex(index)}
              onMouseLeave={() => setHoveredIndex(null)}
              style={{ backgroundImage: `url(${offering.image})` }}
            >
              {/* Gradient overlay */}
              <div className={`offering-overlay ${isHovered ? "offering-overlay--hovered" : ""}`} />

              {/* Content */}
              <div className="offering-content">
                <h3 className={`offering-title ${isHovered ? "offering-title--hovered" : ""}`}>
                  {offering.title}
                </h3>

                <p className={`offering-paragraph ${isHovered ? "offering-paragraph--hovered" : ""}`}>
                  {offering.paragraph}
                </p>

                <a href={offering.path} className="offering-link">
                  <button
                    className={`offering-btn ${isHovered ? "offering-btn--hovered" : ""}`}
                  >
                    Explore
                    <svg
                      width="16"
                      height="16"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M9 5l7 7-7 7"
                      />
                    </svg>
                  </button>
                </a>
              </div>
            </div>
          );
        })}
      </div>
    </section>
  );
}

export default Offerings;

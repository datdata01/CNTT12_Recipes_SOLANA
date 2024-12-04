import React from "react";
import "bootstrap-icons/font/bootstrap-icons.css";

const Footer = () => {
  return (
    <footer className="footer bg-dark text-light py-5">
      <div className="container">
        <div className="row align-items-center">
          {/* Logo and Description */}
          <div className="col-md-6 text-center text-md-start mb-4 mb-md-0">
            <div className="d-flex align-items-center justify-content-center justify-content-md-start">
              <i className="bi bi-controller me-2 fs-3 text-primary"></i>
              <h4 className="mb-0">Solana CNTT 12</h4>
            </div>
            <p className="footer-description mt-2">
              Shop CNTT12 mua và trao đổi vật phẩm game
            </p>
          </div>

          {/* Social Links */}
          <div className="col-md-6 text-center text-md-end">
            <div className="social-links d-flex justify-content-center justify-content-md-end mb-3">
              <a
                href="https://github.com/quanghyyy/Web3.git"
                target="_blank"
                rel="noopener noreferrer"
                className="social-btn me-3"
              >
                <i className="bi bi-github"></i>
              </a>
              <a
                href="https://discord.com/channels/@me"
                target="_blank"
                rel="noopener noreferrer"
                className="social-btn me-3"
              >
                <i className="bi bi-discord"></i>
              </a>
              <a
                href="#"
                target="_blank"
                rel="noopener noreferrer"
                className="social-btn"
              >
                <i className="bi bi-twitter"></i>
              </a>
            </div>
            <p className="footer-copy mt-3">
              © 2024 Shop vật phẩm Game. All rights reserved.
            </p>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;

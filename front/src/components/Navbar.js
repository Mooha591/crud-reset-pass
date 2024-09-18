import React from "react";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import "./Navbar.css";
import "./Alert.css";
import { useNavigate } from "react-router-dom";

const Navbar = ({ auth }) => {
  // const [user, setUser] = useState(getUserInfoFromLocalStorage());
  const [user, setUser] = useState("");
  //SessionTimeOut
  const [time, setTime] = useState(0);
  const [isMobile, setIsmobile] = useState(false); // show-nav

  //* Session expire si on ne fait rien pendant 5 minutes
  const SessionTimeOut = () => {
    setTime(time + 1);
    console.log(time);
    if (time === 3) {
      // 3 minutes
      localStorage.clear();
      window.location.reload();
    }
  };
  useEffect(() => {
    const interval = setInterval(() => {
      SessionTimeOut();
    }, 300000);
    return () => clearInterval(interval);
  }, [time]);

  // ! Navigate
  let navigate = useNavigate(); // Use for Navigate on Previous

  const LogOut = () => {
    localStorage.clear();
    navigate(`/`);
    setUser(auth.first_name("")); // setUser permet de mettre à jour le header pour que le bouton logout disparaisse
    window.location.reload(); // permet de recharger la page pour que le header se mette à jour
  };

  return (
    <>
      <header>
        <nav className="navbar">
          <Link to="/">
            <h3 className="logo">Logo</h3>
          </Link>
          <ul
            className={isMobile ? "nav-links-mobile active" : "nav-links"} // Toggle Mobile Menu
            onClick={() => setIsmobile(false)}
          >
            <Link to="/" className="home">
              <li>Home</li>
            </Link>
            {auth ? ( // si l'utilisateur est connecté on affiche add
              <Link to="/add" className="add">
                <li>Add</li>
              </Link>
            ) : (
              "" // si l'utilisateur n'est pas authentifié on affiche rien
            )}

            {!auth && ( // si l'utilisateur n'est pas connecté on affiche register
              <Link to="/register" className="register">
                <li>Register</li>
              </Link>
            )}

            {auth && ( // Logout nous redirige à la page d'accueil et on supprime le localstorage
              <Link to="/" className="Logout" onClick={LogOut}>
                <li>Logout</li>
              </Link>
            )}

            {!auth && (
              <Link to="/login" className="login">
                <li>Login</li>
              </Link>
            )}
          </ul>

          <button
            className="mobile-menu-icon"
            onClick={() => setIsmobile(!isMobile)} // Toggle Mobile Menu
          >
            {isMobile ? (
              <i className="fas fa-times"></i>
            ) : (
              <i className="fas fa-bars"></i>
            )}
          </button>
        </nav>
        {/* <div className="bar"></div> */}
      </header>
    </>
  );
};

export default Navbar;

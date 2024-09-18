import React from "react";
import { useState, useEffect } from "react";
import { Route, Routes, BrowserRouter } from "react-router-dom";
import Home from "../src/Pages/Home";
import Register from "../src/Pages/Register";
import Login from "../src/Pages/Login";
import Navbar from "../src/components/Navbar";
import ProtectedRoute from "./Pages/ProtectedRoute";
import Add from "./Pages/Add";
import ResetPass from "./Pages/ResetPass";
import ForgotPassword from "./Pages/forgotPassword";

const App = () => {
  const [auth, setAuth] = useState(
    JSON.parse(window.localStorage.getItem("user")) || "" //ça permet de récupérer les données de l'utilisateur connecté et de les stocker dans le state auth
  );

  const [darkMode, setDarkMode] = useState(
    localStorage.getItem("darkMode") === "true" // pour vérifier si le mode sombre est activé ou non
  );

  const handleDarkMode = () => {
    // toggle dark mode
    setDarkMode(!darkMode);
    localStorage.setItem("darkMode", !darkMode);
  };

  useEffect(() => {
    if (darkMode) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  }, [darkMode]);

  return (
    <BrowserRouter>
      {/* nav en entête */}
      <Navbar auth={auth} />
      <div className={darkMode ? "dark-mode" : "light-mode"}>
        <button onClick={handleDarkMode} className="dark-mode__toggle">
          {darkMode ? "Light Mode" : "Dark Mode"}
          {darkMode ? "🌞" : "🌚"}
        </button>
        <Routes>
          <Route path="/" element={<Home />} auth={auth} />
          <Route path="/register" element={<Register />} />
          <Route path="/login" element={<Login setAuth={setAuth} />} />

          <Route
            path="/add"
            element={
              <ProtectedRoute auth={auth}>
                <Add auth={auth} />
              </ProtectedRoute>
            }
          />
          <Route path="resetpass" element={<ResetPass />} />
          <Route path="forgotpass" element={<ForgotPassword />} />
        </Routes>
      </div>
    </BrowserRouter>
  );
};

export default App;

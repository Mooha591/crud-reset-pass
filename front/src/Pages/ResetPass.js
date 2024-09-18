import React from "react";
import { useState } from "react";
import "./ResetPass.css";
import Alert from "../components/Alert";
import axios from "axios";
import { useNavigate } from "react-router-dom";

const ResetPassword = () => {
  const [token, setToken] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [alert, setAlert] = useState({ show: false, type: "", msg: "" });

  let history = useNavigate();

  const handleTokenChange = (e) => {
    setToken(e.target.value);
  };

  const handlePasswordChange = (e) => {
    setPassword(e.target.value);
  };

  const handleConfirmPasswordChange = (e) => {
    setConfirmPassword(e.target.value);
  };

  const showAlert = (show = false, type = "", msg = "") => {
    setAlert({ show, type, msg });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if (password !== confirmPassword) {
      showAlert(true, "danger", "Les mots de passe ne correspondent pas.");
      return;
    }

    if (
      !password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/)
    ) {
      showAlert(
        true,
        "danger",
        "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre."
      );
      return;
    }

    axios
      .post(
        `http://localhost/back2/forgot-password.php?reset_token=${token}`,
        {
          password: password,
          confirm_password: confirmPassword,
        },
        {
          headers: {
            "Content-Type": "application/json",
          },
        }
      )
      .then((response) => {
        if (response.data.success) {
          showAlert(
            true,
            "success",
            "Le mot de passe a été réinitialisé avec succès."
          );
          setTimeout(() => {
            history("/login");
          }, 2000);
        } else {
          showAlert(true, "danger", response.data.message);
        }
      })
      .catch((error) => {
        showAlert(
          true,
          "danger",
          "Erreur lors de la réinitialisation du mot de passe."
        );
        console.error(error);
      });
  };

  return (
    <div>
      <h2>Réinitialisation du mot de passe</h2>
      <form onSubmit={handleSubmit} className="form-reset">
        {alert.show && <Alert {...alert} removeAlert={showAlert} />}
        <div className="container-token">
          <label htmlFor="token">Jeton :</label>
          <input
            type="text"
            id="token"
            value={token}
            onChange={handleTokenChange}
          />
        </div>
        <div className="formc-controle">
          <label htmlFor="password">Nouveau mot de passe :</label>
          <input
            type="password"
            id="password"
            value={password}
            onChange={handlePasswordChange}
          />
        </div>
        <div className="formc-controle">
          <label htmlFor="confirm-password">Confirmer le mot de passe :</label>
          <input
            type="password"
            id="confirm-password"
            value={confirmPassword}
            onChange={handleConfirmPasswordChange}
          />
        </div>
        <button type="submit" className="btn-reset">
          Réinitialiser le mot de passe
        </button>
      </form>
    </div>
  );
};

export default ResetPassword;

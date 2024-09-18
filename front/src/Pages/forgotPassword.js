import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

const EnterEmailForPassword = () => {
  let navigate = useNavigate();
  const [email, setEmail] = useState("");

  const handleChange = (e) => {
    setEmail(e.target.value);
  };
  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!email) {
      alert("Veuillez entrer une adresse e-mail.");
      return;
    }

    try {
      console.log("Envoi de l'e-mail:", email);
      const response = await axios.post(
        "http://localhost/back2/forgot-password-request.php",
        {
          email: email, // Pass the email in the request body
        }
      );

      const data = response.data;
      console.log("Réponse du serveur:", data);
      if (data.success) {
        alert(
          "Un lien de réinitialisation de mot de passe a été envoyé à votre adresse e-mail."
        );
        navigate("/resetpass");
      } else {
        alert("Adresse e-mail introuvable dans la base de données.");
      }
    } catch (error) {
      console.error("Erreur lors de la soumission du formulaire:", error);
      alert("Une erreur s'est produite lors de la soumission du formulaire.");
    }

    // Réinitialisation de l'état de l'e-mail après la soumission du formulaire
    setEmail("");
  };

  return (
    <div className="rp-container">
      <h1>Réinitialiser votre mot de passe</h1>
      <form onSubmit={handleSubmit}>
        <div className="form-group-email">
          <label htmlFor="email">E-mail :</label>
          <input
            type="email"
            id="email"
            name="email"
            value={email}
            onChange={handleChange}
            placeholder="Entrez votre adresse e-mail"
            required
            className="form-control"
          />
        </div>
        <button type="submit" className="btn btn-primary">
          Soumettre
        </button>
      </form>
    </div>
  );
};

export default EnterEmailForPassword;

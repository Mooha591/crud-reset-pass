import React from "react";
import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import Alert from "../components/Alert";
import "./Register.css";

const Register = () => {
  let history = useNavigate(); // pour rediriger vers une autre page
  const [data, setData] = useState({
    // data is an object
    first_name: "",
    last_name: "",
    email: "",
    password: "",
  });

  const [alert, setAlert] = useState({ show: false, type: "", msg: "" });

  // alert
  const showAlert = (show = false, type = "", msg = "") => {
    // j'ai créé une fonction pour afficher les messages d'alerte et je l'ai appelé dans le submitForm pour afficher les messages d'alerte en fonction des conditions de validation du formulaire .
    setAlert({ show, type, msg });
  };

  const handleChange = (e) => {
    setData({ ...data, [e.target.name]: e.target.value }); // ...data = copie de data, [e.target.name] = nom de l'input, e.target.value = valeur de l'input pour pouvoir
  };

  // submit form
  const submitForm = (e) => {
    e.preventDefault();

    // envoyer les données au serveur
    const sendData = {
      // cela permet de créer un objet avec les données du formulaire pour l'envoyer au serveur et de ne pas envoyer les données vides au serveur
      first_name: data.first_name,
      last_name: data.last_name,
      email: data.email,
      password: data.password,
    };

    if (
      // si les champs sont vides
      data.first_name === "" ||
      data.last_name === "" ||
      data.email === "" ||
      data.password === ""
    ) {
      showAlert(true, "danger", "Veuillez remplir tous les champs");
    } else if (
      data.password.match(
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/
      ) === null // regex pour vérifier le mot de passe
    ) {
      showAlert(
        true,
        "danger",
        "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre"
      );
    } else if (
      data.email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/) ===
      null // regex pour vérifier l'email
    ) {
      showAlert(true, "danger", "Veuillez entrer un email valide");
    } else {
      // si les champs sont remplis on envoie les données au serveur
      axios
        .post("http://localhost/back2/register.php", sendData)
        .then((result) => {
          if (result.data.error) {
            showAlert(true, "danger", "Email déjà existant");
          } else {
            showAlert(true, "success", "Inscription réussie");
            setTimeout(() => {
              showAlert(false, "", ""); // enlever l'alerte
              history(`/login`); // rediriger vers la page login
            }, 2000);
          }
        });
    }
  };
  return (
    <div className="container-register">
      <h1>Register</h1>

      <form className="form" onSubmit={submitForm}>
        {alert.show && ( // si alert.show est true alors on affiche l'alerte
          <Alert type={alert.type} msg={alert.msg} removeAlert={showAlert} />
        )}
        <div className="form-control">
          <label htmlFor="first_name">first Name</label>
          <input
            type="text"
            id="first_name"
            onChange={handleChange}
            name="first_name" // permet de récupérer la valeur de l'input
            value={data.first_name} // permet de garder la valeur de l'input
          />
        </div>
        <div className="form-control">
          <label htmlFor="last_name">last Name</label>
          <input
            type="text"
            id="last_name"
            onChange={handleChange}
            name="last_name"
            value={data.last_name}
          />
        </div>
        <div className="form-control">
          <label htmlFor="email">Email</label>
          <input
            type="email"
            id="email"
            onChange={handleChange}
            name="email" // name must be the same as the state
            value={data.email}
          />
        </div>
        <div className="form-control">
          <label htmlFor="password">Password</label>
          <input
            type="password"
            id="password"
            onChange={handleChange}
            name="password"
            value={data.password}
          />
        </div>
        <div className="btn-register">
          <button type="submit" className="btn">
            Register
          </button>
        </div>
      </form>
    </div>
  );
};

export default Register;

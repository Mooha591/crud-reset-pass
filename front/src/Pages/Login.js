import React from "react";
import axios from "axios";
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Link } from "react-router-dom";
import Alert from "../components/Alert";
import "./Login.css";

// const url = "http://localhost/back2/";
const Login = ({ setAuth }) => {
  // elle nous sert à vérifier si l'utilisateur est connecté ou non dans le fichier ProtectedRoute.js pour rediriger l'utilisateur vers la page de connexion si il n'est pas connecté
  let navigate = useNavigate();
  const [user, setUser] = useState({ email: "", password: "" });
  const [alert, setAlert] = useState({ show: false, type: "", msg: "" });

  //reinitialiser input password
  const resetInput = () => {
    setUser({ email: "", password: "" });
  };

  // message d'alert
  const showAlert = (show = false, type = "", msg = "") => {
    setAlert({ show, type, msg });
  };
  // input change
  const handleChange = (e) => {
    setUser({ ...user, [e.target.name]: e.target.value });
  };

  const submitForm = (e) => {
    e.preventDefault();
    resetInput();

    // envoyer les données au serveur
    const sendData = {
      email: user.email,
      password: user.password,
    };

    // connexion axios post ,  puis faut envoyer les données au serveur pour vérifier si l'utilisateur existe ou non dans la base de données et si le mot de passe est correct ou non
    axios.post("http://localhost/back2/login.php", sendData).then((result) => {
      if (result.data.first_name) {
        window.localStorage.setItem("user", JSON.stringify(result.data));
        setAuth(result.data); // pour stocker les données de l'utilisateur dans le state auth pour pouvoir les utiliser dans le fichier ProtectedRoute.js pour vérifier si l'utilisateur est connecté ou non.
        navigate(`/add`);
      } else {
        showAlert(true, "danger", "Connexion échouée");
      }
    });
  };

  return (
    <div className="container-register">
      <h1 className="page-title">Login </h1>

      <form className="form" onSubmit={submitForm}>
        {alert.show && <Alert {...alert} removeAlert={showAlert} />}
        <div className="form-control">
          <label htmlFor="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            onChange={handleChange}
            value={user.email} // pour réinitialiser le champ email
          />
        </div>
        <div className="form-control">
          <label htmlFor="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            onChange={handleChange}
            value={user.password} // pour réinitialiser le champ password
          />
        </div>
        <button type="submit" className="btn">
          Login
        </button>

        {/* <button className="container-reset">
          <Link to="/ResetPass" className="resetPassword-btn">
            Reset password
          </Link>
        </button> */}

        <Link to="/forgotpass" className="container-reset resetPassword-btn">
          Reset password
        </Link>
      </form>
    </div>
  );
};

export default Login;

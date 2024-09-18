import React from "react";
import { useEffect } from "react";
import "./Alert.css";

const Alert = ({ type, msg, removeAlert }) => {
  useEffect(() => {
    const timeout = setTimeout(() => {
      removeAlert();
    }, 3000);

    return () => {
      clearTimeout(timeout); // pour éviter les erreurs de timeout si on clique plusieurs fois sur le bouton
    };
  }, [removeAlert]); // si on met pas [removeAlert] on aura une erreur de timeout
  // todos c'est notre tableau de tâche qui est dans le state de Add.js

  return <p className={`alert alert-${type}`}>{msg}</p>;
};

export default Alert;

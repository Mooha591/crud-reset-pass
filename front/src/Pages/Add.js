import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";
import Alert from "../components/Alert";
import { FaEdit, FaTrash } from "react-icons/fa";
import "./Add.css";
// const url = "http://localhost/back2/";
const url = "http://localhost/back2/";

const Add = ({ auth }) => {
  const [todos, setTodos] = useState([]); // todos = tableau de tâche vide au début pour afficher les données du server dans le tableau
  const [task, setTask] = useState(""); // permet de récupérer la tâche saisie dans le formulaire
  const [alert, setAlert] = useState({ show: false, type: "", msg: "" });
  const [editID, setEditID] = useState(null); //  permet de récupérer l'id de la tâche à modifier pour l'envoyer au serveur
  const [isEditing, setIsEditing] = useState(false); // permet de savoir si on est en mode edit ou non

  // message d'alert
  const showAlert = (show = false, type = "", msg = "") => {
    setAlert({ show, type, msg });
  };

  const fetchAsk = async () => {
    // création d'une fonction asynchrone pour récupérer les données du server et les afficher dans le tableau
    const { data } = await axios(`${url}read.php?id=${auth.user_id}`); // data dans un objet destructuré pour récupérer les données du server
    setTodos(data); // pour afficher les données
  };

  useEffect(() => {
    fetchAsk();
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    //si les champs sont vides on affiche un message sinon on edit ou on ajoute
    if (!task || task.trim() === "") {
      // trim() permet de supprimer les espaces avant et après la chaine de caractères
      // trim() permet de supprimer les espaces avant et après la chaine de caractères
      setTask("");
      showAlert(true, "danger", "Veuillez entrer une tâche");
    } else if (task && isEditing) {
      //si on est en mode edit on envoi les données au server pour les modifier. sinon on ajoute une nouvelle tâche dans la base de données
      try {
        const person = {
          task_id: parseInt(editID), // id de la tache
          title: task, // titre de la tache
          user_id: auth.user_id, // id de l'utilisateur
        };

        console.log(person);
        // parseInt() convertit une chaîne de caractères en nombre entier.
        await axios.post(`${url}edited.php`, person);

        showAlert(true, "success", "Tâche modifiée");
        setTask("");
        setEditID(null); // pour vider le champ input
        fetchAsk();
        setIsEditing(false);
        // name , lastname, email
      } catch (error) {
        showAlert(true, "danger", "Erreur,essayez encore");
      }
    } else {
      try {
        const person = { title: task, user_id: auth.user_id };
        await axios.post(`${url}taskCreate.php`, person);
        showAlert(true, "success", "Nom ajouté");
        fetchAsk(); // pour afficher les données
        setTask(""); // pour vider le champ input
      } catch (error) {
        // eslint-disable-line
        showAlert(true, "danger", "Erreur,essayez encore");
      }
    }
  };
  const deleteTask = async (id) => {
    // on prend l'id de la tache pour la supprimer dans la base de données et dans le tableau de tâche.

    await axios.post(`${url}delete.php`, { task_id: id }); // id de la tache
    fetchAsk();
    setEditID(null);
    setIsEditing(false);
    showAlert(true, "danger", "valeur supprimée");

    console.log(id);
  };

  // supprimer toute les tâche d'un utilisateur avec un bouton
  const AlldeleteTaskUsers = async (id) => {
    await axios.post(`${url}clearall.php`, { user_id: id });
    fetchAsk();
    setEditID(null);
    setIsEditing(false);
    setTodos([]); // pour vider le tableau
    showAlert(true, "danger", "toutes les valeurs ont été supprimées");
  };

  const editTasks = async (id) => {
    await axios.post(`${url}edited.php`, { task_id: id, user_id: id }); // id de la tache et id de l'utilisateur
    const task = todos.find((person) => person.task_id === id); // recupere le nom de la tache
    setEditID(id); // recupere l'id de la tache
    setIsEditing(true);
    setTask(task.title); // recupere le nom de la tache dans l'input pour le modifier
  };

  return (
    <>
      <article>
        <div className="div-alert">
          {alert.show && <Alert {...alert} removeAlert={showAlert} />}
        </div>
        <div className="container-alpha">
          <form className="container-form-add" onSubmit={handleSubmit}>
            <div className="div-utilisateur">
              {auth && (
                <span className="utilisateur">
                  Bonjour : {auth.first_name} {auth.last_name}
                </span>
              )}
            </div>
            <div className="form-group-add">
              {/* {todos.length < 1 && (  */}
              <div className="nbr-tasks">
                <h3 htmlFor="Tasks">Tâches : {todos.length}</h3>
              </div>
              {/* )} */}
              <div className="input-form-add">
                <input
                  type="text"
                  className="form-control-add"
                  id="Tasks"
                  placeholder="enter task"
                  onChange={(e) => setTask(e.target.value)}
                  value={task}
                />
              </div>
              <div className="div-btn-addTask">
                <button type="submit" className="addTask">
                  {isEditing ? "modifier la tâche" : "ajouter une tâche"}
                </button>
              </div>
            </div>
          </form>
          <div>
            {todos.map((task) => {
              const { task_id, title } = task; // destructuring
              return (
                <div className="container-list-items" key={task_id}>
                  <div className="task">
                    <div className="title-item">
                      <p>{title}</p>
                    </div>
                    <div className="div-btn">
                      <button
                        className="buttonEdit"
                        onClick={() => editTasks(task_id)}
                      >
                        <FaEdit />
                      </button>
                    </div>
                    <div className="div-btn">
                      <button
                        className="buttonDelete"
                        onClick={() => deleteTask(task_id)}
                      >
                        <FaTrash />
                      </button>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
          {todos.length > 0 && (
            <div className="div-deleteAll">
              <button
                className="deleteAll"
                onClick={() => AlldeleteTaskUsers(auth.user_id)} // supprimer toute les tâches d'un utilisateur par son id
              >
                supprimer toutes les tâches
              </button>
            </div>
          )}

          {todos.length < 1 && (
            <div className="noTask">
              <h3>Vous n'avez pas de tâche</h3>
            </div>
          )}
        </div>
      </article>
    </>
  );
};

export default Add;

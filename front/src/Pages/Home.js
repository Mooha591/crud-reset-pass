import React from "react";
import image2 from "../images/image2.jpg";
import "./Home.css";

const Home = () => {
  return (
    <>
      <div className="home_page">
        <h1 className="home_page_title">Bienvenu dans la page d'accueil </h1>
        <img className="image2" src={image2} alt="image2" />
      </div>
    </>
  );
};

export default Home;

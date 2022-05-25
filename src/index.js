import React from "react";
import ReactDOM from "react-dom";
import './css/index.css';
import App from "./App";
import ContextWrapper from "./context/ContextWrapper";

ReactDOM.render(
  <React.StrictMode>
    <ContextWrapper>
      <App />
    </ContextWrapper>
  </React.StrictMode>,
  document.getElementById("root")
);

import axios from 'axios';
import './App.scss'
import { Route, Routes } from 'react-router-dom';
import PublicRoute from './routes/PublicRoute';
import PrivateRoute from './routes/PrivateRoute';

function App() {
 
  axios.defaults.baseURL = "http://localhost:8000/";
  axios.defaults.headers.post["Content-Type"] = "application/json";
  axios.defaults.headers.post["Accept"] = "application/json";
  axios.defaults.withCredentials = true;
  axios.interceptors.request.use(function (config) {
    const token = localStorage.getItem("auth_token");
    config.headers.Authorization = token ? `Bearer ${token}` : "";
    return config;
  });
  return (
    <Routes>
    <Route exact path="/*" element={<PublicRoute />} />
    <Route path="/admin/*" element={<PrivateRoute />} />
  </Routes>
  )
}

export default App

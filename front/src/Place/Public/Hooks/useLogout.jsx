import { useState } from "react";

import { useAuthContext } from "./useAuthContext";
import axios from "axios";
import { useNavigate } from "react-router-dom";

export const useLogout = () => {
  const navigate = useNavigate();
  const { dispatch: dispatchAuthAction } = useAuthContext();

  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);

  const logout = async () => {
    setError(null);
    setIsLoading(true);
    try {
      axios.post(`/api/logout`).then((res) => {
        if (res.data.status === 200) {
          localStorage.removeItem("auth_token");
          localStorage.removeItem("auth_name");
          // swal("Success",res.data.message,"success");
          navigate("/");
        }
      });
      dispatchAuthAction({ type: "LOGOUT" });
    } catch (err) {
      console.log(err);
      setError(err);
      setIsLoading(false);
    }
  };

  return { logout, isLoading, error };
};

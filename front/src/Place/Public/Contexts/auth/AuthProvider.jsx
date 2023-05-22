/* eslint-disable react/prop-types */
import { useEffect, useReducer } from "react";

import AuthContext from "./auth-context";
import axios from "axios";

const initialState = {
  user: null,
  name: null,
  lastName: null,
  email: null,
  phoneNumber: null,
  addresses: [],
  isVerified: false,
  authIsReady: false,
  role_as:0
};

const authReducer = (state, action) => {
  switch (action.type) {
    case "AUTH_IS_READY": {
      return {
        user: action.payload.user,
        name: action.payload.name,
        lastName: action.payload.lastName,
        email: action.payload.email,
        phoneNumber: action.payload.phoneNumber || null,
        addresses: action.payload.addresses || [],
        isVerified: true,
        authIsReady: true,
        role_as:action.payload.role_as
      };
    }

    case "ANONYMOUS_AUTH_IS_READY": {
      return {
        ...initialState,
        user: action.payload.user,
        authIsReady: true,
      };
    }

    case "LOGIN": {
      return {
        ...state,
        user: action.payload.user,
        name: action.payload.name,
        lastName: action.payload.lastName,
        email: action.payload.email,
        phoneNumber: action.payload.phoneNumber || null,
        addresses: action.payload.addresses || [],
        isVerified: action.payload.isVerified,
        role_as:action.payload.role_as
      };
    }

    case "LOGOUT": {
      return {
        ...initialState,
      };
    }

    case "UPDATE_USER": {
      return {
        ...state,
        ...action.payload,
      };
    }

    case "UPDATE_ADDRESSES": {
      return {
        ...state,
        addresses: action.payload,
      };
    }

    default: {
      return state;
    }
  }
};

const AuthProvider = ({ children }) => {
  const [state, dispatch] = useReducer(authReducer, initialState);
  useEffect(() => {
    const check = (user) => {
      
      axios.get(`api/currentLogin`).then((res) => {
        if (res.data.status === 200) {
          if (res.data.user) {
            const dataUser = res.data.user;
            dispatch({
              type: "AUTH_IS_READY",
              payload: { user, ...dataUser },
            });
          } else {
            const user = res.data.anonymous;
            dispatch({
              type: "ANONYMOUS_AUTH_IS_READY",
              payload: { user },
            });
          }

          console.log(res);
        } else if (res.data.status === 401) {
          // swal("Warning",res.data.message,"warning");
        } else {
          // setLogin({...loginInput, error_list: res.data.validation_errors });
        }
      });
      
    };
   
    return () => check();
  }, []);

  console.log("auth-context", state);

  return (
    <AuthContext.Provider value={{ ...state, dispatch }}>
      {children}
    </AuthContext.Provider>
  );
};

export default AuthProvider;

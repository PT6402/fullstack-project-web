/* eslint-disable react/prop-types */
import { useEffect, useReducer } from "react";

import AuthContext from "./auth-context";

const initialState = {
    user: null,
    name: null,
    lastName: null,
    email: null,
    phoneNumber: null,
    addresses: [],
    isVerified: false,
    authIsReady: false,
    role_as: 0,
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
                role_as: action.payload.role_as,
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
                role_as: action.payload.role_as,
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
            if (localStorage.getItem("auth_token")) {
                const dataUser = localStorage.getItem("auth_token");
                dispatch({
                    type: "AUTH_IS_READY",
                    payload: { user, ...dataUser },
                });
            } else {
                dispatch({
                    type: "ANONYMOUS_AUTH_IS_READY",
                    payload: { user },
                });
            }

            // console.log(res);
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

/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
import { useState } from "react";
import { useAuthContext } from "./useAuthContext";
import { useNavigate } from "react-router-dom";
import CryptoJS from "crypto-js";



// import axiosClient from "../http";
import axios from "axios";

export const useLogin = () => {
    const { dispatch } = useAuthContext();
    const navigate = useNavigate();
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);

    const login = async ({ email, password }) => {
        setError(null);
        setIsLoading(true);
        try {
            await axios.get("/sanctum/csrf-cookie");
            const loginResponse = await axios.post(`api/login`, {
                email,
                password,
            });
            localStorage.setItem("auth_token", loginResponse.data.token);
            if (loginResponse.data.status === 200) {
                let cartData = {};
                const cartResponse = await axios.get(`api/view-cartitem`);
                if (cartResponse.data.status === 200) {
                    cartData = {
                        items: cartResponse.data.cartItem,
                        totalAmount: cartResponse.data.cart.total_amount,
                        status_cart: 1,
                    };
                } else if (
                    cartResponse.data.cart == "cart empty" ||
                    cartResponse.data.cartitem == "cartItem empty"
                ) {
                    cartData = {
                        items: [],
                        totalAmount: 0,
                        status_cart: 0,
                    };
                } else {
                    console.log(cartResponse.data);
                }

                console.log(cartData);
                let userData = {};
                if (loginResponse.data.role === "admin") {
                    userData = {
                        user: loginResponse.data.username,
                        name: loginResponse.data.username,
                        email: loginResponse.data.email,
                        isVerified: true,
                        authIsReady: true,
                        role_as: 2,
                    };
                } else {
                    userData = {
                        user: loginResponse.data.username,
                        name: loginResponse.data.username,
                        email: loginResponse.data.email,
                        isVerified: true,
                        authIsReady: true,
                        role_as: 0,
                    };
                }
                const data = { userData, cartData };
                const string = JSON.stringify(data);
                const originalData = string;
                const secretKey = loginResponse.data.token;
                const encryptedData = CryptoJS.AES.encrypt(
                    originalData,
                    secretKey
                ).toString();
                localStorage.setItem("encryptedData", encryptedData);
                console.log(loginResponse.data);

                dispatch({
                    type: "LOGIN",
                    payload: { ...userData },
                });

                if (loginResponse.data.role === "admin") {
                    navigate("/admin/dashboard/home");
                } else {
                    navigate("/");
                }
            } else if (loginResponse.data.status === 401) {
                setError({ details: "Wrong username or password" });
            } else {
                console.log(loginResponse.data);
            }
            setIsLoading(false);
        } catch (err) {

            setIsLoading(false);
        }

    };

    return { login, isLoading, error };
};

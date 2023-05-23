/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
import { useContext, useState } from "react";
import { useAuthContext } from "./useAuthContext";
import { useNavigate } from "react-router-dom";
import CryptoJS from "crypto-js";
// import { useCartContext } from "./useCartContext";

// import { updateCartAtLogin } from "../helpers/cart";
// import axiosClient from "../http";
import axios from "axios";

export const useLogin = () => {
    const { dispatch } = useAuthContext();

    // const { dispatch: dispatchCartAction, items, totalAmount } = useCartContext();
    const navigate = useNavigate();
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);

    const login = async ({ email, password }) => {
        setError(null);
        setIsLoading(true);

        axios.get("/sanctum/csrf-cookie").then((response) => {
            axios.post(`api/login`, { email, password }).then((res) => {
                if (res.data.status === 200) {
                    localStorage.setItem("auth_token", res.data.token);

                    let userData = {};
                    if (res.data.role === "admin") {
                        userData = {
                            user: res.data.username,
                            name: res.data.username,
                            email: res.data.email,
                            isVerified: true,
                            authIsReady: true,
                            role_as: 2,
                        };
                    } else {
                        userData = {
                            user: res.data.username,
                            name: res.data.username,
                            email: res.data.email,
                            isVerified: true,
                            authIsReady: true,
                            role_as: 0,
                        };
                    }
                    const data = { userData };
                    const string = JSON.stringify(data);
                    const originalData = string;
                    const secretKey = res.data.token;
                    const encryptedData = CryptoJS.AES.encrypt(
                        originalData,
                        secretKey
                    ).toString();
                    localStorage.setItem("encryptedData", encryptedData);
                    console.log(res.data);
                    if (res.data.role === "admin") {
                        navigate("/admin/dashboard/home");
                    } else {
                        navigate("/");
                    }
                } else if (res.data.status === 401) {
                    setError({ details: "Wrong username or password" });
                } else {
                    // setLogin({...loginInput, error_list: res.data.validation_errors });
                    console.log(res.data);
                }
            });
        });
        setIsLoading(false);

        // const userCredential = await signInWithEmailAndPassword(
        //   auth,
        //   email,
        //   password
        // );

        // if (!userCredential) {
        //   throw new Error("Error");
        // }

        // const user = userCredential.user;

        // const cartRef = doc(db, 'carts', user.uid);
        // const cartDoc = await getDoc(cartRef);

        // const anonymousCartRef = doc(db, 'carts', anonymousUser.uid);
        // const anonymousCartDoc = await getDoc(anonymousCartRef);

        // if (cartDoc.exists()) {
        //   const cartData = cartDoc.data();

        // if (anonymousCartDoc.exists()) {
        //   await deleteDoc(doc(db, 'carts', anonymousUser.uid));

        //   const itemsForCartUpdate = [...cartData.items, ...items];
        //   const updatedCart = updateCartAtLogin(itemsForCartUpdate);

        //   // await setDoc(cartRef, updatedCart);

        //   dispatchCartAction({
        //     type: 'UPDATE_CART',
        //     payload: { ...updatedCart },
        //   });
        // } else {
        // }
        // } else {
        //   if (anonymousCartDoc.exists()) {
        //     await deleteDoc(doc(db, 'carts', anonymousUser.uid));

        //     await setDoc(cartRef, { items, totalAmount });
        //   }
        // }
        let cartData = {};
        // dispatchCartAction({
        //   type: "UPDATE_CART",
        //   payload: { ...cartData },
        // });

        // } catch (err) {
        // console.log(err.code);
        // if (
        //   err.code === "auth/wrong-password" ||
        //   err.code === "auth/user-not-found"
        // ) {
        //   setError({ details: "Wrong username or password" });
        // } else {
        //   setError(err);
        // }
        // setIsLoading(false);
        // }
    };

    return { login, isLoading, error };
};

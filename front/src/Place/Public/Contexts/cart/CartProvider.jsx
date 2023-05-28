/* eslint-disable react/prop-types */
import { useReducer, useEffect } from "react";

// import { doc, getDoc } from 'firebase/firestore';
// import { db } from '../../firebase/config';
import CryptoJS from "crypto-js";

import { useAuthContext } from "../../Hooks/useAuthContext";

import CartContext from "./cart-context";

const initialState = {
    items: [],
    totalAmount: 0,
    cartIsReady: false,
};

const cartReducer = (state, action) => {
    switch (action.type) {
        case "CART_IS_READY": {
            return {
                ...state,
                cartIsReady: true,
            };
        }
        case "UPDATE_CART": {
            return {
                items: action.payload.items,
                totalAmount: action.payload.totalAmount,
                cartIsReady: true,
            };
        }
        case "DELETE_CART": {
            return {
                ...initialState,
                cartIsReady: true,
            };
        }

        default: {
            return state;
        }
    }
};

const CartProvider = ({ children }) => {
    const { user } = useAuthContext();
    const [state, dispatch] = useReducer(cartReducer, initialState);

    useEffect(() => {
        if (user) {
            const getCart = async () => {
                try {
                    const encryptedData = localStorage.getItem("encryptedData");
                    const secretKey = localStorage.getItem("auth_token");
                    const decryptedData = CryptoJS.AES.decrypt(
                        encryptedData,
                        secretKey
                    ).toString(CryptoJS.enc.Utf8);
                    const { cartData } = JSON.parse(decryptedData);
                    console.log(cartData);
                    if (cartData.status_cart==1) {
                        dispatch({
                            type: "UPDATE_CART",
                            payload: { items:cartData.items ,totalAmount:cartData.totalAmount},
                        });
                    } else {
                        dispatch({
                            type: "CART_IS_READY",
                        });
                    }
                } catch (err) {
                    console.log(err);
                }
            };

            getCart();
        }
    }, [user]);

    console.log("cart-context", state);

    return (
        <CartContext.Provider value={{ ...state, dispatch }}>
            {children}
        </CartContext.Provider>
    );
};

export default CartProvider;

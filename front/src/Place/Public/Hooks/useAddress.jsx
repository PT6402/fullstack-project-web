import { useState } from "react";

import { useAuthContext } from "./useAuthContext";
import axios from "axios";
import CryptoJS from "crypto-js";
export const useAddress = () => {
    const { addresses, dispatch } = useAuthContext();

    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    const userAddresses = [addresses];

    const createAddress = async ({
        address,
        note,
        city_province,
        default_address,
        // isFromCheckout = null,
    }) => {
        setError(null);
        setIsLoading(true);
        try {
            axios
                .post("api/store-address", {
                    address,
                    note,
                    city_province,
                    default_address,
                })
                .then((res) => {
                    if (res.data.status === 200) {
                        let encryptedData = localStorage.getItem("encryptedData");
                        let secretKey = localStorage.getItem("auth_token");
                        let decryptedData = CryptoJS.AES.decrypt(
                          encryptedData,
                          secretKey
                        ).toString(CryptoJS.enc.Utf8);
                        const { userData, cartData } = JSON.parse(decryptedData);

                        localStorage.removeItem("encryptedData");

                        console.log(userData);

                        userData.addresses =res.data.address;

                        console.log(userData);

                        const string = JSON.stringify({ userData,cartData });
                        const originalData = string;

                        encryptedData = CryptoJS.AES.encrypt(
                          originalData,
                          secretKey
                        ).toString();
                        localStorage.setItem("encryptedData", encryptedData);


                        console.log(res.data.address);
                        dispatch({
                            type: "UPDATE_ADDRESSES",
                            payload: res.data.address,
                        });
                        setIsLoading(false);
                    }
                });
        } catch (err) {
            console.log(err);
            setError(err);
            setIsLoading(false);
        }
    };

    const editAddress = async ({
        address,
        note,
        city_province,
        default_address,
    }) => {
        setError(null);
        setIsLoading(true);
        try {
            // Check so that there is always at least one address that is default

            axios
                .post("api/store-address", {
                    address,
                    note,
                    city_province,
                    default_address,
                })
                .then((res) => {
                    if (res.data.status === 200) {
                        dispatch({
                            type: "UPDATE_ADDRESSES",
                            payload: address,
                        });
                        setIsLoading(false);
                    }
                });

            dispatch({ type: "UPDATE_ADDRESSES", payload: address });

            setIsLoading(false);
        } catch (err) {
            console.log(err);
            setError(err);
            setIsLoading(false);
        }
    };

    const deleteAddress = async (id) => {
        setError(null);
        setIsLoading(true);

        try {
            // const checkoutSessionDoc = await getDoc(checkoutSessionRef);

            // if (checkoutSessionDoc.exists()) {
            //   const { shippingAddress } = checkoutSessionDoc.data();
            //   if (shippingAddress.id === id) {
            //     await updateDoc(checkoutSessionRef, {
            //       shippingAddress: {},
            //     });
            //   }
            // }

            const updatedAddresses = userAddresses.filter(
                (address) => address.id !== id
            );

            if (updatedAddresses.length > 0) {
                for (let i = 1; i <= updatedAddresses.length; i++) {
                    updatedAddresses[i - 1].displayOrder = i;
                }

                const checkForMain = updatedAddresses.find(
                    (address) => address.isMain
                );

                if (!checkForMain) {
                    updatedAddresses[0].isMain = true;
                }
            }

            // await updateDoc(userRef, {
            //   addresses: updatedAddresses,
            // });

            dispatch({ type: "UPDATE_ADDRESSES", payload: updatedAddresses });

            setIsLoading(false);
        } catch (err) {
            console.log(err);
            setError(err);
            setIsLoading(false);
        }
    };

    return { createAddress, editAddress, deleteAddress, isLoading, error };
};

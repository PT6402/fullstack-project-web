import { useState } from "react";

// import { doc, updateDoc } from 'firebase/firestore';

// import { db } from '../firebase/config';
import CryptoJS from "crypto-js";
import { useAuthContext } from "./useAuthContext";
import axios from "axios";

export const useProfile = () => {
    const { dispatch } = useAuthContext();

    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(false);

    const editProfile = async ({ name, phoneNumber = null }) => {
        setError(null);
        setIsLoading(true);
        try {
            await axios
                .post("api/update-phone-name", { name, phone: phoneNumber })
                .then((res) => {
                    if (res.data.status == 200) {
                        let encryptedData =
                            localStorage.getItem("encryptedData");
                        let secretKey = localStorage.getItem("auth_token");
                        let decryptedData = CryptoJS.AES.decrypt(
                            encryptedData,
                            secretKey
                        ).toString(CryptoJS.enc.Utf8);
                        let { userData } = JSON.parse(decryptedData);
                        userData = { ...userData, phoneNumber, name };

                        localStorage.removeItem("encryptedData");

                        const data = { userData };
                        const string = JSON.stringify(data);
                        const originalData = string;

                        encryptedData = CryptoJS.AES.encrypt(
                            originalData,
                            secretKey
                        ).toString();
                        localStorage.setItem("encryptedData", encryptedData);
                        dispatch({
                            type: "UPDATE_USER",
                            payload: { name, phoneNumber },
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

    return { editProfile, isLoading, error };
};

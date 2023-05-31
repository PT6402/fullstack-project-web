/* eslint-disable react/prop-types */
import { useReducer, useEffect } from "react";

import { useParams, useLocation, useNavigate } from "react-router-dom";

import ProductContext from "./product-context";
import axios from "axios";

const initialState = {
    productIsReady: false,
    selectedProduct: null,
    selectedColor: null,
    selectedSku: "",
    selectedSize: "",
    selectedStock: 0,
};

const productReducer = (state, action) => {
    switch (action.type) {
        case "CLEAR_PRODUCT": {
            return {
                ...initialState,
            };
        }
        case "SET_PRODUCT": {
            return {
                ...state,
                productIsReady: true,
                selectedProduct: action.payload.product
            };
        }
        case "SELECT_COLOR": {
            return {
                ...state,
                selectedColor: action.payload,
                selectedSku: "",
                selectedSize: "",
                selectedStock: 0,
            };
        }
        case "SELECT_SIZE": {
            return {
                ...state,
                selectedSku: action.payload.id,
                selectedSize: action.payload.value,
                selectedStock: action.payload.stock,
            };
        }
        default: {
            return state;
        }
    }
};

const ProductProvider = ({ children }) => {
    const { id: urlId } = useParams();
    const { state: locationState } = useLocation();
    const navigate = useNavigate();

    const [state, dispatch] = useReducer(productReducer, initialState);

    const getProduct = async () => {
        if (state.productIsReady) {
            dispatch({ type: "CLEAR_PRODUCT" });
        }

        let product;
        axios.get("/api/list-product").then((res) => {
            if (res.data.status == 200) {
                product = res.data.products;
                console.log(res.data.products);
            }
        });

        return { product };
    };

    useEffect(() => {
        const fetchProduct = async () => {
            const { product } = await getProduct();

            dispatch({
                type: "SET_PRODUCT",
                payload: {
                    product,
                },
            });
        };

        fetchProduct();
    }, [urlId]);

    useEffect(() => {
        if (locationState === "/product") {
            const fetchProduct = async () => {
                const {
                    product,
                } = await getProduct();

                dispatch({
                    type: "SET_PRODUCT",
                    payload: {
                        product,
                    },
                });
                navigate(".");
            };

            fetchProduct();
        }
    }, [locationState]);

    console.log("product-context", state);

    return (
        <ProductContext.Provider value={{ ...state, dispatch }}>
            {children}
        </ProductContext.Provider>
    );
};

export default ProductProvider;

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
                selectedProduct: action.payload.selectedProduct,
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

    const getProduct =async () => {
        if (state.productIsReady) {
         dispatch({ type: "CLEAR_PRODUCT" });
        }

        let selectedProduct=[];
        // let inventory =[]
        await axios.get("/api/list-product").then((res) => {
            if (res.data.status == 200) {
                selectedProduct = res.data.products;
                // inventory = inventory.push(res.data.products.colorSizes);
                console.log(res.data.products);
                // console.log(res.data.products.colorSizes);
            }
        });

        return { selectedProduct };
    };

    useEffect(  () => {
        const fetchProduct =async () => {
            const { selectedProduct } = await getProduct();
            if (selectedProduct) {
                dispatch({
                    type: "SET_PRODUCT",
                    payload: {
                        selectedProduct: selectedProduct,
                    },
                });
                console.log(selectedProduct);
            }
        };

        fetchProduct();
    }, [urlId]);

    useEffect(() => {

        if (locationState == "/product") {

            const fetchProduct = () => {
                const { selectedProduct } = getProduct();

                if (selectedProduct) {
                    dispatch({
                        type: "SET_PRODUCT",
                        payload: {
                            selectedProduct: selectedProduct
                        },
                    });
                    console.log(selectedProduct)
                    navigate(".");
                }
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

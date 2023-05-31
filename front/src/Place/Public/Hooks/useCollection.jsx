import axios from "axios";
import { useEffect, useState } from "react";

// import { collection, getDocs } from 'firebase/firestore';

// import { db } from '../firebase/config';

export const useCollection = () => {
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);


    // const productsRef = collection(db, 'products');

    const getCollection = async () => {
        setError(null);
        setIsLoading(true);
        try {
            const products = [];
           await axios.get("/api/list-product").then((res) => {
                if (res.data.status == 200) {
                    products.push(res.data.products);
                    console.log(res.data.products);
                }
            });
            setIsLoading(false);
            return products;

            //   const variants = []

            //   for (const product of products) {
            //     for (const variant of product.variants) {
            //       variants.push({
            //         model: product.product_name,
            //         collection: product.category_name,
            //         type: product.product_type,
            //         id: variant.id,
            //         color: variant.colorSizes.color_name,
            //         price: variant.product_price,
            //         url: variant.product_slug,
            //         images: variant.images,
            //         numberOfVariants: product.variants.length,
            //       });
            //     }
            //   }

        } catch (err) {
            console.log(err);
            setError(err);
            setIsLoading(false);
        }
    };

    return { getCollection, isLoading, error };
};

import { useState } from "react";

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
      // const products = [];
      const variants = [];

      const products = [
        {
          model: "Baires",
          collection: "accesorios",
          type: "gorro",
          variants: [
            {
              variantId: "300101",
              color: "blanco",
              price: 4150,
              url: "gorro-baires-blanco",
              images: [
                { src: "images/productos-gorro-baires-blanco-1.jpg", id: "1" },
                { src: "images/productos-gorro-baires-blanco-2.jpg", id: "2" },
              ],
            },

          ],
        },
      ];

      for (const product of products) {
        for (const variant of product.variants) {
          variants.push({
            model: product.model,
            collection: product.collection,
            type: product.type,
            id: variant.variantId,
            color: variant.color,
            price: variant.price,
            url: variant.url,
            images: variant.images,
            numberOfVariants: product.variants.length,
          });
        }
      }

      return variants;
    } catch (err) {
      console.log(err);
      setError(err);
      setIsLoading(false);
    }
  };

  return { getCollection, isLoading, error };
};

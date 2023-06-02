/* eslint-disable react/prop-types */
// import { useProduct } from 'hooks/useProduct';

import styles from "./index.module.scss";

const ProductVariant = ({ id, color_name, selectedVariantId }) => {
    const { selectVariant } = [];

    let shouldAddEventHandler = false;
    if (selectedVariantId !== id) {
        shouldAddEventHandler = true;
    }

    const handleSelectVariant = () => {
        if (id === selectedVariantId) {
            return;
        }
        selectVariant(id);
    };

    let variantStyles =
        selectedVariantId === id ? styles.thumbnail_selected : styles.thumbnail;

    // const thumbnail = require(`../../../assets/${_thumbnail}`);

    return (
        <img
          className={variantStyles}
          onClick={shouldAddEventHandler ? handleSelectVariant : undefined}
        //   src={`../../../../../../src/assets/${}`}
          alt=""
        />
        // <>
        //     <div
        //         className={variantStyles}
        //         onClick={
        //             shouldAddEventHandler ? handleSelectVariant : undefined
        //         }
        //     >
        //         {color_name}
        //     </div>
        // </>
    );
};

export default ProductVariant;

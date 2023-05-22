
import { useEffect } from "react";

import { IoIosCheckmarkCircle, IoIosAlert } from "react-icons/io";

import styles from "./index.module.scss";

const ToastMessage = ({ toggleToast, content, className }) => {
  useEffect(() => {
    const timer = setTimeout(() => {
      toggleToast();
    }, 6000);

    return () => {
      clearTimeout(timer);
    };
  }, [content]);

  if (content.addToCartSuccess) {
    // const thumbnail = require(`../../assets/${content._thumbnail}`);
    return (
      <div className={`${styles.addToCart} ${styles.success}`}>
        <div className={styles.content_wrapper}>
          <img className={styles.image} src={`../../../src/assets/${content._thumbnail}`} alt="" />
          <div>
            <p className={styles.title}>Product added to cart.</p>
            <p className={styles.details}>
              {content.details || "La operacion se realizó con éxito."}
            </p>
          </div>
        </div>
        <i className={styles.icon}>
          <IoIosCheckmarkCircle />
        </i>
      </div>
    );
  }

  if (content.error) {
    return (
      <div className={`${styles.error} ${className}`}>
        <div className={styles.content_wrapper}>
          <div>
            <p className={styles.title}>Error</p>
            <p className={styles.error_details}>{content.details || ""}</p>
            {/* The operation could not be performed. */}
          </div>
        </div>
        <i className={styles.icon}>
          <IoIosAlert />
        </i>
      </div>
    );
  }
};

export default ToastMessage;

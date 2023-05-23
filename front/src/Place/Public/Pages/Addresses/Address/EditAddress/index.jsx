/* eslint-disable react/prop-types */
import { useState, useEffect, useRef } from "react";

// import { useAddress } from "../../../../../../hooks/useAddress";
// import { useKeyDown } from "../../../../../../hooks/useKeyDown";

// import Loader from "../../../../../../components/Loader";

import styles from "./index.module.scss";
import { useAddress } from "../../../../Hooks/useAddress";
import { useKeyDown } from "../../../../Hooks/useKeyDown";
import Loader from "../../../../Components/Loader";

const EditAddress = ({
  toggleEditAddressModal,
  name,
  lastName,
  phoneNumber,
  address,
  zipCode,
  city,
  province,
  isMain,
  id,
  displayOrder,
}) => {
  const { editAddress, isLoading, error } = useAddress();
  // const { editAddress, isLoading, error } = [];

  const [isChecked, setIsChecked] = useState(isMain);
  const [toggle, setToggle] = useState(false);

  const handleCheckboxInput = () => {
    setIsChecked((prevState) => !prevState);
  };

  const nameInput = useRef();
  const lastNameInput = useRef();
  const phoneNumberInput = useRef();
  const addressInput = useRef();
  const zipCodeInput = useRef();
  const cityInput = useRef();
  const provinceInput = useRef();

  const handleSubmit = async (e) => {
    e.preventDefault();

    await editAddress({
      name: nameInput.current.value,
      lastName: lastNameInput.current.value,
      phoneNumber: phoneNumberInput.current.value,
      address: addressInput.current.value,
      zipCode: zipCodeInput.current.value,
      city: cityInput.current.value,
      province: provinceInput.current.value,
      isMain: isChecked,
      id,
      displayOrder,
    });

    setToggle(true);
  };

  useEffect(() => {
    if (toggle && !error) {
      toggleEditAddressModal();
    } else {
      setToggle(false);
    }
  }, [error, toggle, toggleEditAddressModal]);

  useKeyDown(() => {
    toggleEditAddressModal();
  }, ["Escape"]);

  return (
    <>
      {isLoading && (
        <Loader noPortal={true} wrapperClassName={styles.loader_wrapper} />
      )}
      {!isLoading && (
        <form id="form" className={styles.form} onSubmit={handleSubmit}>
          <h2 className={styles.title}>Edit Address</h2>
          <div className={styles.form_inputs_wrapper}>
            <label className={styles.label}>
              <span>Name:</span>
              <input
                className={styles.input}
                type="text"
                placeholder="Name"
                required
                ref={nameInput}
                defaultValue={name}
              />
            </label>
            <label className={styles.label}>
              <span>Last name:</span>
              <input
                className={styles.input}
                type="text"
                placeholder="Last name"
                required
                ref={lastNameInput}
                defaultValue={lastName}
              />
            </label>
            <label className={styles.label}>
              <span>Phone:</span>
              <input
                className={styles.input}
                type="tel"
                required
                ref={phoneNumberInput}
                defaultValue={phoneNumber}
              />
            </label>
            <label className={styles.label}>
              <span>Address:</span>
              <input
                className={styles.input}
                type="text"
                required
                ref={addressInput}
                defaultValue={address}
              />
            </label>
            <label className={styles.label}>
              <span>City/Town:</span>
              <input
                className={styles.input}
                type="text"
                required
                ref={cityInput}
                defaultValue={city}
              />
            </label>
            <label className={styles.label}>
              <span>Postal Code:</span>
              <input
                className={styles.input}
                type="text"
                inputMode="numeric"
                required
                ref={zipCodeInput}
                defaultValue={zipCode}
              />
            </label>

            <label className={styles.label}>
              <span>Province:</span>
              <input
                className={styles.input}
                type="text"
                required
                ref={provinceInput}
                defaultValue={province}
              />
            </label>
            <label className={styles.checkbox}>
              <input
                className={styles.input}
                type="checkbox"
                checked={isChecked}
                onChange={handleCheckboxInput}
                disabled={isMain}
              />
              <div>Default address</div>
            </label>
          </div>
          <div className={styles.button_wrapper}>
            <button form="form" className={styles.button} type="submit">
              Edit
            </button>
          </div>
        </form>
      )}
    </>
  );
};

export default EditAddress;

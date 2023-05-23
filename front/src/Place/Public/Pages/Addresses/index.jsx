import { useEffect, useState } from "react";
import { useAuthContext } from "../../Hooks/useAuthContext";
import Toast from "../../Components/Toast";
import ToastMessage from "../../Components/ToastMessage";
import CenterModal from "../../Components/CenterModal";
import Address from "./Address";
import classNames from "classnames/bind";
const cx = classNames.bind(style);
import style from "./index.module.scss";
import { useAddress } from "../../Hooks/useAddress";
import { Link } from "react-router-dom";
import Button from "../../Components/Button";
import { BiChevronLeft, BiPlus } from 'react-icons/bi';
import Loader from "../../Components/Loader";
import AddAddress from "./AddAddress";
export default function Addresses() {
    const { addresses } = useAuthContext();
    const { deleteAddress, isLoading, error } = useAddress();
    // const { addresses } =[]
    // const { deleteAddress, isLoading, error } =[]

    const [isOpen, setIsOpen] = useState(false);
    const [toastMessage, setToastMessage] = useState(null);

    const defaultAddress = addresses.find((address) => address.isMain);

    const otherAddresses = addresses.filter((address) => !address.isMain);

    const toggleAddAddressModal = () => {
      setIsOpen((prevState) => !prevState);
    };

    useEffect(() => {
      if (error) {
        setToastMessage({ error, details: error.details });
      }
    }, [error]);

    const toggleToast = () => {
      setToastMessage(null);
    };

    return (
      <>
        <Toast>
          {toastMessage && (
            <ToastMessage toggleToast={toggleToast} content={toastMessage} />
          )}
        </Toast>
        <CenterModal
          modalClassName={cx("modal")}
          toggleModal={toggleAddAddressModal}
        >
          {isOpen && <AddAddress toggleAddAddressModal={toggleAddAddressModal} />}
        </CenterModal>
        <section>
          <div className={`${cx("container")} main-container`}>
            <Link className={cx("back_button")} to="/account">
              <span>
                <BiChevronLeft />
              </span>
              Back to my account
            </Link>
            <div className={cx("header_wrapper")}>
              <p className={cx("title")}>My Addresses</p>
              <Button
                className={cx("add_button")}
                onClick={toggleAddAddressModal}
              >
                <span>
                  <BiPlus />
                </span>
                Add new address
              </Button>
            </div>

            <div className={cx("addresses_container")}>
              {isLoading && (
                <Loader
                  wrapperClassName={cx("loader_wrapper")}
                  noPortal={true}
                />
              )}
              {!isLoading && (
                <>
                  {addresses.length === 0 && (
                    <h2 className={cx("no_addresses")}>
                    You have not added an address yet!
                    </h2>
                  )}

                  {addresses.length > 0 && (
                    <div className={cx("addresses_list")}>
                      {defaultAddress && (
                        <Address
                          name={defaultAddress.name}
                          lastName={defaultAddress.lastName}
                          phoneNumber={defaultAddress.phoneNumber}
                          address={defaultAddress.address}
                          zipCode={defaultAddress.zipCode}
                          city={defaultAddress.city}
                          province={defaultAddress.province}
                          id={defaultAddress.id}
                          isMain={defaultAddress.isMain}
                          onDelete={deleteAddress}
                        />
                      )}
                      {otherAddresses.map((address) => (
                        <Address
                          key={address.id}
                          name={address.name}
                          lastName={address.lastName}
                          phoneNumber={address.phoneNumber}
                          address={address.address}
                          zipCode={address.zipCode}
                          city={address.city}
                          province={address.province}
                          id={address.id}
                          isMain={address.isMain}
                          displayOrder={address.displayOrder}
                          onDelete={deleteAddress}
                        />
                      ))}
                    </div>
                  )}
                </>
              )}
            </div>
          </div>
        </section>
      </>
    );
}

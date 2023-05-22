import  { useEffect, useRef, useState } from 'react'
import { Link, useLocation } from 'react-router-dom';
import classNames from "classnames/bind";
const cx = classNames.bind(style);
import style from './index.module.scss';
import { useLogin } from '../../Hooks/useLogin';
import Toast from '../../Components/Toast';
import ToastMessage from '../../Components/ToastMessage';
import Loader from '../../Components/Loader';
export default function ResetPassword() {
    const { state: routerState } = useLocation();

    const { login, isLoading, error } = useLogin();
  
    const [toastMessage, setToastMessage] = useState(null);
  
    const emailInput = useRef();
    const passwordInput = useRef();
  
    const handleSubmit = async (e) => {
      e.preventDefault();
  
      await login({
        email: emailInput.current.value,
        password: passwordInput.current.value,
      });
    };
  
    useEffect(() => {
      if (error) {
        setToastMessage({ error, details: error.details });
      }
      // console.log(error);
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
        {isLoading && <Loader />}
        {!isLoading && (
          <>
            <section className={cx("nav_section")}></section>
            <section className={cx("section")}>
              <div className={cx("container")}>
                <div className={`${cx("wrapper")} main-container`}>
                  <form onSubmit={handleSubmit} className={cx("form")}>
                    <h2 className={cx("title")}>Reset Password</h2>
                  
                    <label className={cx("label")}>
                      <span>Password:</span>
                      <input
                        className={cx("input")}
                        type="password"
                        placeholder="password"
                        required
                        ref={passwordInput}
                      />
                    </label>
                    <label className={cx("label")}>
                      <span>Confirm Password:</span>
                      <input
                        className={cx("input")}
                        type="password"
                        placeholder="confirm password"
                        required
                        ref={passwordInput}
                      />
                    </label>
                    <button className={cx("button")} type="submit">
                     Go To Website -&gt;
                    </button>
                  </form>
                  
                </div>
              </div>
            </section>
          </>
        )}
      </>
    );
}

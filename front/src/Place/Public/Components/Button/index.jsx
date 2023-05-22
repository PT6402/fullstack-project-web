/* eslint-disable react/prop-types */
import { Link } from 'react-router-dom';
import classNames from "classnames/bind";
import style from "./index.module.scss";
const cx = classNames.bind(style);


const Button = ({ children, className, to, type, onClick }) => {
  if (to) {
    return (
      <Link
        to={to}
        className={`${cx("button")} ${className}`}
        onClick={onClick}
      >
        {children}
      </Link>
    );
  }

  return (
    <button
      type={type}
      className={`${cx("button")} ${className}`}
      onClick={onClick}
    >
      {children}
    </button>
  );
};

export default Button;

import { Route, Routes } from "react-router-dom";
import Layout from "../Place/Public/Layouts";
import Home from "../Place/Public/Pages/Home";
import Collections from "../Place/Public/Pages/Collections";
import Checkout from "../Place/Public/Pages/Checkout";
import Account from "../Place/Public/Pages/Account";
import Addresses from "../Place/Public/Pages/Addresses";
import Cart from "../Place/Public/Pages/Cart";
import Signup from "../Place/Public/Pages/Signup";
import Login from "../Place/Public/Pages/Login";
import AuthProvider from "../Place/Public/Contexts/auth/AuthProvider";
import CartProvider from "../Place/Public/Contexts/cart/CartProvider";
import ForgetPassword from "../Place/Public/Pages/ForgetPassword";
import ResetPassword from "../Place/Public/Pages/ResetPassword";

export default function PublicRoute() {
  return (
    <AuthProvider>
      <CartProvider>
        <Routes>
          <Route element={<Layout />}>
            <Route index  element={<Home />} />
            <Route path="/category/:id" element={<Collections />} />
            <Route path="/product/:id" />
            <Route path="/checkout" element={<Checkout />} />
            <Route path="/account" element={<Account />} />
            <Route path="/account/address" element={<Addresses />} />
            <Route path="/cart" element={<Cart />} />
            <Route path="/account/signup" element={<Signup />} />
            <Route path="/account/login" element={<Login />} />
            <Route path="/account/login/forget-password" element={<ForgetPassword />} />
            <Route path="/account/login/reset-password" element={<ResetPassword />} />
          </Route>
        </Routes>
      </CartProvider>
    </AuthProvider>
  );
}

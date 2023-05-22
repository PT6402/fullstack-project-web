import { createContext } from 'react';

const AuthContext = createContext({
  user: null,
  name: null,
  lastName: null,
  email: null,
  phoneNumber: null,
  addresses: [],
  isVerified: false,
  authIsReady:false,
  role_as:0
});

export default AuthContext;

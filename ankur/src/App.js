import React, {useState} from 'react';
import { SocialSignIn, SocialSignOut } from 'react-easy-auth'
import './index.css'


export const App = () => {
  const [user, setUser] = useState(null)
 
  //a method to fetch user data from the SocialSignIn component
  const fetchUserData = (userData, userCredentials, error) => {
    if (!error) {
      setUser(userData)
    }
  }
 
  // a method to handle sign-out 
  const onSignOut = (error) => {
    if (!error) {
      console.log('signed out')
      setUser(null)
    }
  }
 
// if the user data is present we show the SocialSignOut Compononent
  if (user) {
    return (
      <div>
        <h1> Welcome {user.displayName} </h1>
        <SocialSignOut style={{ color: 'red' }} onSignOut={onSignOut} />
      </div>
    )
  }
 
// if there is no user data we show the SocialSignIn Component
  return (
        <div className="container">
          <h1 className="title"> Sign Up </h1>
          <div className="buttons">
            <SocialSignIn
              authProvider='Google'
              style={{ color: 'white', backgroundColor: 'red', fontSize: '20px', borderRadius: '5px' }}
              fetchUserData={fetchUserData}
            />
            <SocialSignIn
              authProvider='Facebook'
              style={{ color: 'white', backgroundColor: 'blue', fontSize: '20px', borderRadius: '5px' }}
              fetchUserData={fetchUserData}
            />
            <SocialSignIn
              authProvider='Twitter'
              style={{ color: 'white', backgroundColor: 'purple', fontSize: '20px', borderRadius: '5px' }}
              fetchUserData={fetchUserData}
            />
          </div>
        </div>
  )
}

export default App;

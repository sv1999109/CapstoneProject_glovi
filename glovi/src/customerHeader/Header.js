

import React, { Component } from 'react';
import './Header.css';
//import { Link } from 'react-router-dom';

class CustomNavLink extends Component {
  state = { clicked: false };

  handleClick = () => {
    this.setState({ clicked: !this.state.clicked });
  };

  render() {
    return (
      <header>
        <nav className='container'>
          <div id='menu' className={this.state.clicked ? "menu active" : "Menu"}>
            <ul>
              <li className='main-content'> <a className="active" href="/">Address Book</a></li>
              <li> <a href="/ManageInvoice">Manage Invoice</a></li>
              <li> <a href="/Orders">Orders</a></li>
              <li> <a href="/Payments">Payments</a></li>
            </ul>
          </div>
        </nav>
      </header>
    );
  }
}

export default CustomNavLink;

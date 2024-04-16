import React, { useState } from 'react';
import './DashboardNav.css'; 
import logo from "../../assets/logo_main.PNG";

const DashboardNavbar = () => {
  const [isOpen, setIsOpen] = useState(false);

  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  return (
    <nav className={`dashboard-navbar ${isOpen ? 'open' : ''}`}>
      <div className="navbar-header">
        <div className="logo">
            <a href="/"> <img id="Logo" src={logo} alt="Logo" /> </a>
        </div>
        <div className="menu-toggle" onClick={toggleMenu}>
          Toggle
        </div>
      </div>
      <ul className="navbar-nav">
        <li className="nav-heading">Menu</li>
        <li className="nav-item">
          <a href="/Dashboard" className="nav-link">Dashboard</a>
        </li>
        <li className="nav-item">
          <a href="#create-shipment" className="nav-link">Create Shipment</a>
        </li>
        <li className="nav-item">
          <a href="#pending" className="nav-link">Pending</a>
        </li>
        <li className="nav-item">
          <a href="#manage-shipments" className="nav-link">Manage Shipments</a>
        </li>
        <li className="nav-heading">Customers</li>
        <li className="nav-item">
          <a href="/AddressBook" className="nav-link">Address Book</a>
        </li>
        <li className="nav-item">
          <a href="/Orders" className="nav-link">Orders</a>
        </li>
        <li className="nav-item">
          <a href="/ManageInvoice" className="nav-link">Manage Invoice</a>
        </li>
        <li className="nav-item">
          <a href="/Payments" className="nav-link">Payments</a>
        </li>
      </ul>
    </nav>
  );
};

export default DashboardNavbar;
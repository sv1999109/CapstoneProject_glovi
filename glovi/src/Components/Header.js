import logo from "../assets/logo_main.PNG"
import React, { Component } from "react";
import "./HeaderStyle.css"
import { Link } from 'react-router-dom';

class Navbar extends Component {
    state = { clicked: false };

    handleClick = () => {
        this.setState({ clicked: !this.state.clicked })
    };

    state = { servicesClicked: false };

    toggleServicesDropdown = () => {
        this.setState({ servicesClicked: !this.state.servicesClicked });
    };

    render() {
        return (
            <header>

                <nav>
                    <a href="/"> <img id="Logo" src={logo} alt="Logo" /> </a>

                    <div id="Menu" className={this.state.clicked ? "menu active" : "Menu"}>
                        <li> <a className="active" href="/">Home</a> | </li>
                        <li> <a href="/Shipping">Shipping</a> | </li>
                        <li className="Menu" onMouseEnter={this.toggleServicesDropdown} onMouseLeave={this.toggleServicesDropdown}>
                            <a href="#">Services</a>
                            {this.state.servicesClicked && (
                                <ul className="dropdown">
                                    <li><a href="/PalletService">Pallet Shipping Service</a></li>
                                    <li><a href="/ContainerService">Container Shipping Service</a></li>
                                    <li><a href="/VanService">Van Transport Service</a></li>
                                    <li><a href="/TruckService">Truck Transport Service</a></li>
                                    <li><a href="/ParcelService">Parcel Delivery</a></li>
                                    <li><a href="/DocumentsService">Documents Shipping Service</a></li>
                                </ul>
                            )}
                        </li>
                        <li> <a href="/AboutUs">About</a> | </li>
                        <li> <a href="/GetEstimate">Get An Estimate</a> | </li>
                        <li><Link to="/login"><button className="btnSignup">Sign Up</button></Link></li>

                    </div>

                    <div id="mobile">
                        {/* if clicked show  close icon else show menu icon */}
                        <i id="bar" className={this.state.clicked ? "fas fa-times" : "fas fa-bars"} onClick={this.handleClick}> </i>
                    </div>
                </nav>
            </header>
        );
    }
}
export default Navbar;
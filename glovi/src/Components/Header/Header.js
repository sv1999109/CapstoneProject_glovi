import React, { Component } from "react";
import "./HeaderStyle.css";
import { Link } from "react-router-dom";
import { FiSearch } from "react-icons/fi";
import { FaAngleDown } from "react-icons/fa";
import { TfiMenuAlt } from "react-icons/tfi";
import logo from "../../assets/logo_main.PNG";
import { IoCloseSharp } from "react-icons/io5";

class Navbar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isSearchOpen: false,
            isSidebarOpen: false,
            isMoreSubMenuOpen: false,
            isJsSubMenuOpen: false,
            navLinksClass: ""
        };
    }

    toggleSearch = () => {
        this.setState(prev => ({
            isSearchOpen: !prev.isSearchOpen
        }));
    }


    // toggleSidebar = () => {
    //     this.setState((prevState) => ({
    //         isSidebarOpen: !prevState.isSidebarOpen,
    //     }));
    // };
    toggleSidebar = () => {
        this.setState((prevState) => ({
            isSidebarOpen: !prevState.isSidebarOpen,
            isJsSubMenuOpen: false, // Reset the state of isJsSubMenuOpen when sidebar is toggled
            navLinksClass: prevState.isSidebarOpen ? "" : "show"
        }));
    };
    toggleMoreSubMenu = () => {
        this.setState((prevState) => ({
            isMoreSubMenuOpen: !prevState.isMoreSubMenuOpen,
        }));
    };

    toggleJsSubMenu = () => {
        this.setState((prevState) => ({
            isJsSubMenuOpen: !prevState.isJsSubMenuOpen,
        }));
    };

    closeSidebar = () => {
        this.setState({
            isSidebarOpen: false,
        });
    };

    render() {
        const {
            isSearchOpen,
            isSidebarOpen,
            isJsSubMenuOpen,
        } = this.state;

        return (
            <header>
                <nav>
                    <div className="navbar">
                        <TfiMenuAlt className="bx bx-menu" onClick={this.toggleSidebar} />

                        <div className="logo">
                            <a href="/"> <img id="Logo" src={logo} alt="Logo" /> </a>
                        </div>
                        <div className={`nav-links ${this.state.navLinksClass}`} style={{right: isSidebarOpen ? 0 : "-100%" }}>
                            <div className="sidebar-logo">
                                <IoCloseSharp className='CloseIcon' onClick={this.closeSidebar} />
                            </div>

                            <ul className="links">
                                <li>
                                    <a href="/">Home</a>
                                </li>
                                <li> <a href="/Shipping">Shipping</a> </li>
                                <li>
                                    <a href="#">Services</a>
                                    <FaAngleDown className="bx bxs-chevron-down js-arrow arrow"
                                        onClick={this.toggleJsSubMenu} />

                                    <ul className={`js-sub-menu sub-menu ${isJsSubMenuOpen ? "show3" : ""}`}>
                                        <li><a href="/PalletService"><i className="fas fa-pallet orange-icon"></i> Pallet Shipping Service</a></li>
                                        <li><a href="/ContainerService"><i className="fas fa-shipping-fast orange-icon"></i> Container Shipping Service</a></li>
                                        <li><a href="/VanService"><i className="fas fa-shuttle-van orange-icon"></i> Van Transport Service</a></li>
                                        <li><a href="/TruckService"><i className="fas fa-truck orange-icon mr-4"></i> Truck Transport Service</a></li>
                                        <li><a href="/ParcelService"><i className="fas fa-box orange-icon"></i> Parcel Delivery</a></li>
                                        <li><a href="/DocumentsService"><i className="fas fa-file-alt orange-icon"></i> Documents Shipping Service</a></li>
                                    </ul>
                                </li>
                                <li><a href="/AboutUs">About Us</a></li>
                                <li> <a href="/GetEstimate">Get An Estimate</a> </li>
                                <li><Link to="/Signup"><button className="btnSignup">Sign Up Free</button></Link></li>
                                <li><Link to="/Login"><button className="btnlogin">Sign In</button></Link></li>
                            </ul>

                        </div>
                       
                    </div>
                </nav>
            </header>
        );
    }
}

export default Navbar;

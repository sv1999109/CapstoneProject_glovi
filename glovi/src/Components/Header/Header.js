import React, { Component } from "react";
import "./HeaderStyle.css";
import { Link } from "react-router-dom";
import { FiSearch } from "react-icons/fi";
import logo from "../../assets/logo_main.PNG";

class Navbar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isSearchOpen: false,
            isSidebarOpen: false,
            isMoreSubMenuOpen: false,
            isJsSubMenuOpen: false,
        };
    }

    toggleSearchBox = () => {
        this.setState((prevState) => ({
            isSearchOpen: !(prevState.isSearchOpen),
        }));
    };

    toggleSidebar = () => {
        this.setState((prevState) => ({
            isSidebarOpen: !prevState.isSidebarOpen,
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

    render() {
        const {
            isSearchOpen,
            isSidebarOpen,
            isMoreSubMenuOpen,
            isJsSubMenuOpen,
        } = this.state;

        return (
            <header>
                <nav>
                    <div className="navbar">
                        <i
                            className="bx bx-menu"
                            onClick={this.toggleSidebar}
                        ></i>
                        <div className="logo">
                            <a href="/"> <img id="Logo" src={logo} alt="Logo" /> </a>
                        </div>
                        <div className="nav-links" style={{ left: isSidebarOpen ? 0 : "-100%" }}>
                            <div className="sidebar-logo">
                                <span className="logo-name">CodingLab</span>
                                <i className="bx bx-x" onClick={this.toggleSidebar}></i>
                            </div>
                            <ul className="links">
                                <li>
                                    <a href="#">HOME</a>
                                </li>
                                <li>
                                    <a href="#">JAVASCRIPT</a>
                                    <i
                                        className="bx bxs-chevron-down js-arrow arrow"
                                        onClick={this.toggleJsSubMenu}
                                    ></i>
                                    <ul className={`js-sub-menu sub-menu ${isJsSubMenuOpen ? "show3" : ""}`}>
                                        <li><a href="#">Dynamic Clock</a></li>
                                        <li><a href="#">Form Validation</a></li>
                                        <li><a href="#">Card Slider</a></li>
                                        <li><a href="#">Complete Website</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">ABOUT US</a></li>
                                <li><a href="#">CONTACT US</a></li>
                                <li>
                                    <Link to="/Signup"><button className="btnSignup">Sign Up</button></Link></li>
                                <li><Link to="/Login"><button className="btnSignup">Sign In</button></Link></li>
                            </ul>
                        </div>
                        <div className="search-box">
                            <i className={`bx ${isSearchOpen ? "bx-x" : "bx-search"}`} onClick={this.toggleSearchBox}><FiSearch /></i>
                            {isSearchOpen && (
                                <div className="input-box">
                                    <input type="text" placeholder="Search..." />
                                </div>
                            )}
                        </div>
                    </div>
                </nav>
            </header>
        );
    }
}

export default Navbar;

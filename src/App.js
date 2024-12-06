import { TOKEN_PROGRAM_ID } from "@solana/spl-token";
import {
  clusterApiUrl,
  Connection,
  LAMPORTS_PER_SOL,
  PublicKey,
} from "@solana/web3.js";
import "bootstrap-icons/font/bootstrap-icons.css";
import "bootstrap/dist/css/bootstrap.min.css";
import React, { useCallback, useEffect, useMemo, useState } from "react";
import {
  Button,
  Col,
  Container,
  Nav,
  Navbar,
  NavDropdown,
  Row,
  Spinner,
} from "react-bootstrap";
import {
  Navigate,
  NavLink,
  Route,
  BrowserRouter as Router,
  Routes,
} from "react-router-dom";
import "./App.css";
import AuthForm from "./components/AuthForm";
import Home from "./components/Home";
import MyNfts from "./components/MyNfts";
import Footer from "./components/Footer"; // Import Footer component
import PurchaseHistory from "./components/PurchaseHistory";

const USDC_MINT_ADDRESS = new PublicKey(
  "4zMMC9srt5Ri5X14GAgXhaHii3GnPAEERYPJgZJDncDU"
);

function App() {
  const [userData, setUserData] = useState(null);
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  const connection = useMemo(
    () => new Connection(clusterApiUrl("devnet"), "confirmed"),
    []
  );

  const [walletAddress, setWalletAddress] = useState(null);
  const [walletBalance, setWalletBalance] = useState(0);
  const [usdcBalance, setUsdcBalance] = useState(null);
  const [walletLoading, setWalletLoading] = useState(false);
  const [walletError, setWalletError] = useState(null);

  const getUsdcBalance = async (connection, walletPublicKey) => {
    try {
      const publicKey = typeof walletPublicKey === 'string'
        ? new PublicKey(walletPublicKey)
        : walletPublicKey;

      const tokenAccounts = await connection.getParsedTokenAccountsByOwner(
        publicKey,
        { programId: TOKEN_PROGRAM_ID }
      );

      const usdcAccount = tokenAccounts.value.find(
        (account) => account.account.data.parsed.info.mint === USDC_MINT_ADDRESS.toBase58()
      );

      return usdcAccount
        ? usdcAccount.account.data.parsed.info.tokenAmount.uiAmount || 0
        : 0;
    } catch (error) {
      console.error('Lỗi khi lấy số dư USDC:', error);
      return 0;
    }
  };

  const fetchUsdcBalance = useCallback(async () => {
    if (walletAddress) {
      try {
        const balance = await getUsdcBalance(connection, walletAddress);
        setUsdcBalance(balance);
      } catch (error) {
        console.error('Lỗi khi lấy số dư USDC:', error);
        setUsdcBalance(0);
      }
    }
  }, [walletAddress, connection]);

  useEffect(() => {
    if (walletAddress) {
      fetchUsdcBalance();
    }
  }, [walletAddress, fetchUsdcBalance]);

  const connectWallet = async () => {
    setWalletLoading(true);
    setWalletError(null);
    try {
      const provider = window.phantom?.solana;

      if (!provider?.isPhantom) {
        throw new Error("Vui lòng cài đặt Phantom Wallet!");
      }

      if (provider.isConnected) {
        await provider.disconnect();
      }

      await provider.connect({ onlyIfTrusted: false });

      const publicKey = provider.publicKey;
      if (!publicKey) {
        throw new Error("Không thể lấy địa chỉ ví. Vui lòng thử lại.");
      }

      setWalletAddress(publicKey.toString());
      await getWalletBalance(publicKey);
      await fetchUsdcBalance();

    } catch (err) {
      console.error("Lỗi khi kết nối ví:", err);
      setWalletError(
        err.code === 4001
          ? "Kết nối ví bị từ chối. Vui lòng thử lại."
          : err.message || "Không thể kết nối ví. Vui lòng thử lại."
      );
    } finally {
      setWalletLoading(false);
    }
  };

  const getWalletBalance = async (publicKey) => {
    try {
      const balance = await connection.getBalance(publicKey);
      setWalletBalance(balance / LAMPORTS_PER_SOL);
    } catch (err) {
      console.error("Lỗi khi lấy số dư:", err);
      setWalletError("Không thể lấy số dư ví. Vui lòng thử lại.");
    }
  };

  const disconnectWallet = async () => {
    try {
      const provider = window.phantom?.solana;
      if (provider) {
        await provider.disconnect();
        setWalletAddress(null);
        setWalletBalance(0);
        setUsdcBalance(null);
      }
    } catch (err) {
      console.error("Lỗi khi ngắt kết nối ví:", err);
      setWalletError("Không thể ngắt kết nối ví. Vui lòng thử lại.");
    }
  };

  const handleLogout = () => {
    setIsLoggedIn(false);
    setUserData(null);
    disconnectWallet();
  };

  return (
    <Router>
      <div className="app-container">
        {!isLoggedIn ? (
          <div className="auth-container">
            <AuthForm setIsLoggedIn={setIsLoggedIn} setUserData={setUserData} />
          </div>
        ) : (
          <>
            {/* Thêm ảnh vào trên Header */}
            <div className="header-banner">
              <img
                src="/images/banner_header.png"
                alt="Banner Header"
                className="header-image"
              />
            </div>

            <Navbar expand="lg" bg="dark" variant="dark">
              <Container fluid className="px-0">
                {" "}
                {/* Sử dụng container-fluid để không có padding */}
                {/* Phần logo và menu bên trái */}
                <Navbar.Brand className="ms-0">
                  <img
                    src="/images/logo.png"
                    alt="Logo"
                    className="navbar-logo"
                  />
                </Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                  <Nav className="me-auto ms-0">
                    {" "}
                    {/* Loại bỏ margin trái và phải */}
                    <Nav.Link as={NavLink} to="/home">
                      <i className="bi bi-house-door me-2"></i>Trang chủ
                    </Nav.Link>
                    <Nav.Link as={NavLink} to="/my-nfts">
                      <i className="bi bi-bank me-2"></i>Kho NFT
                    </Nav.Link>
                    <Nav.Link as={NavLink} to="/purchase-history">
                      <i className="bi bi-bank me-2"></i>Lịch sử mua hàng
                    </Nav.Link>
                  </Nav>

                  {/* Phần tài khoản sát bên phải */}
                  <Nav className="ms-auto d-flex align-items-center">
                    {/* Phần kết nối ví sát bên phải */}
                    <div className="d-flex align-items-center ms-3">
                      {!walletAddress ? (
                        <Button
                          variant="success"
                          onClick={connectWallet}
                          disabled={walletLoading}
                        >
                          {walletLoading ? (
                            <Spinner as="span" animation="border" size="sm" />
                          ) : (
                            "Kết nối ví"
                          )}
                        </Button>
                      ) : (
                        <div className="d-flex align-items-center">
                          <span className="me-3">
                            SOL: <strong>{walletBalance.toFixed(2)} SOL</strong>
                          </span>
                          <span>
                            USDC:{" "}
                            <span className="fw-bold text-white ms-1">
                              {usdcBalance !== null
                                ? usdcBalance.toFixed(2)
                                : "Đang tải..."}{" "}
                              USDC
                            </span>
                          </span>
                          <Button
                            variant="outline-danger"
                            size="sm"
                            onClick={disconnectWallet}
                            className="ms-3"
                          >
                            Ngắt kết nối
                          </Button>
                        </div>
                      )}
                    </div>
                    <NavDropdown
                      title={
                        <>
                          <i className="bi bi-person-circle me-2"></i>
                          {userData?.email || "Tài khoản"}
                        </>
                      }
                      id="user-dropdown"
                    >
                      <NavDropdown.Divider />
                      <NavDropdown.Item
                        onClick={handleLogout}
                        className="text-danger text-center"
                      >
                        <i className="bi bi-box-arrow-right me-2"></i>
                        Đăng xuất
                      </NavDropdown.Item>
                    </NavDropdown>
                  </Nav>
                </Navbar.Collapse>
              </Container>
            </Navbar>
            {walletError && (
              <Container fluid>
                <div className="alert alert-danger mt-2">{walletError}</div>
              </Container>
            )}

            <Container className="mt-3">
              <Routes>
                <Route path="/" element={<Navigate to="/home" replace />} />
                <Route
                  path="/home"
                  element={<Home referenceId={userData?.referenceId} />}
                />
                <Route
                  path="/my-nfts"
                  element={<MyNfts referenceId={userData?.referenceId} />}
                />
                <Route
                  path="/purchase-history"
                  element={
                    <PurchaseHistory userReferenceId={userData?.referenceId} />
                  }
                />
              </Routes>
            </Container>
          </>
        )}
        <Footer />{" "}
        {/* Footer component is placed outside Routes to ensure it is always visible */}
      </div>
    </Router>
  );
}

export default App;

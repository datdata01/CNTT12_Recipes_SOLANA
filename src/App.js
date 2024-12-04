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

  const fetchUsdcBalance = useCallback(async () => {
    if (walletAddress) {
      try {
        const tokenAccounts = await connection.getParsedTokenAccountsByOwner(
          new PublicKey(walletAddress),
          { programId: TOKEN_PROGRAM_ID }
        );

        const usdcAccount = tokenAccounts.value.find(
          (account) =>
            account.account.data.parsed.info.mint ===
            USDC_MINT_ADDRESS.toBase58()
        );

        setUsdcBalance(
          usdcAccount?.account.data.parsed.info.tokenAmount.uiAmount || 0
        );
      } catch (error) {
        console.error("Lỗi khi lấy số dư USDC:", error);
        setUsdcBalance(0);
      }
    }
  }, [walletAddress, connection]);

  const connectWallet = async () => {
    setWalletLoading(true);
    setWalletError(null);
    try {
      const provider = window.phantom?.solana;

      if (!provider?.isPhantom) {
        throw new Error("Vui lòng cài đặt Phantom Wallet!");
      }

      await provider.connect();
      const publicKey = provider.publicKey;
      setWalletAddress(publicKey.toString());
      const balance = await connection.getBalance(publicKey);
      setWalletBalance(balance / LAMPORTS_PER_SOL);
      await fetchUsdcBalance();
    } catch (err) {
      console.error("Lỗi khi kết nối ví:", err);
      setWalletError(err.message || "Không thể kết nối ví.");
    } finally {
      setWalletLoading(false);
    }
  };

  const disconnectWallet = async () => {
    const provider = window.phantom?.solana;
    if (provider) {
      await provider.disconnect();
      setWalletAddress(null);
      setWalletBalance(0);
      setUsdcBalance(null);
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
            <Navbar expand="lg" bg="dark" variant="dark">
              <Container>
                <Navbar.Brand>
                  <i className="bi bi-controller me-2"></i>Solana CNTT 12
                </Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                  <Nav className="me-auto">
                    <Nav.Link as={NavLink} to="/home">
                      <i className="bi bi-house-door me-2"></i>Trang chủ
                    </Nav.Link>
                    <Nav.Link as={NavLink} to="/my-nfts">
                      <i className="bi bi-bank me-2"></i>Kho NFT
                    </Nav.Link>
                  </Nav>
                  <Nav>
                    <NavDropdown
                      title={
                        <>
                          <i className="bi bi-person-circle me-2"></i>
                          {userData?.email || "Tài khoản"}
                        </>
                      }
                      id="user-dropdown"
                    >
                      {!walletAddress ? (
                        <NavDropdown.Item>
                          <Button
                            variant="success"
                            onClick={connectWallet}
                            disabled={walletLoading}
                            className="w-100"
                          >
                            {walletLoading ? (
                              <Spinner as="span" animation="border" size="sm" />
                            ) : (
                              "Kết nối ví"
                            )}
                          </Button>
                        </NavDropdown.Item>
                      ) : (
                        <>
                          <NavDropdown.ItemText>
                            <div className="d-flex flex-column">
                              <span>
                                SOL:{" "}
                                <strong>{walletBalance.toFixed(2)} SOL</strong>
                              </span>
                              <span>
                                USDC:{" "}
                                <strong>
                                  {usdcBalance !== null
                                    ? usdcBalance.toFixed(2)
                                    : "Đang tải..."}
                                </strong>
                              </span>
                            </div>
                          </NavDropdown.ItemText>
                          <NavDropdown.Item>
                            <Button
                              variant="outline-danger"
                              size="sm"
                              onClick={disconnectWallet}
                              className="w-100"
                            >
                              Ngắt kết nối
                            </Button>
                          </NavDropdown.Item>
                        </>
                      )}
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

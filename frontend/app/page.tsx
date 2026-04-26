"use client";
import { useEffect, useState } from "react";
import { text } from "stream/consumers";

type Cliente = {
  id: number;
  nome: string;
  email: string;
};

type ApiResponse = {
  success: boolean;
  message: string;
};

export default function Home() {
  const [clientes, setClientes] = useState<Cliente[]>([]);
  const [nome, setNome] = useState("");
  const [email, setEmail] = useState("");
  const [id, setId] = useState<string>("");

  const [mensagem, setMensagem] = useState<string>("");
  const [erro, setErro] = useState<boolean>(false);

  const API_URL = "http://localhost:8000/index.php";

  const fetchClientes = async () => {
    try {
      const res = await fetch(API_URL);
      const data = await res.json();
      setClientes(data);
    } catch (err) {
      setMensagem("Erro ao buscar clientes");
      setErro(true);
    }
  };

  const handleResponse = async (res: Response) => {
    try {
      const data: ApiResponse = await res.json();
      setMensagem(data.message);
      setErro(!data.success);
      
    } catch {
      setMensagem("Erro inesperado na resposta do servidor");
      setErro(true);
    }
  };

  const criarCliente = async () => {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nome, email }),
    });

    await handleResponse(res);

    // limpa inputs
    setNome("");
    setEmail("");

    fetchClientes();
  };

  const deletarCliente = async () => {
    const res = await fetch(API_URL, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id }),
    });

    await handleResponse(res);

    // limpa input
    setId("");

    fetchClientes();
  };

  const atualizarCliente = async () => {
    const res = await fetch(API_URL, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, nome, email }),
    });

    await handleResponse(res);

    // limpa inputs
    setId("");
    setNome("");
    setEmail("");

    fetchClientes();
  };

  useEffect(() => {
    fetchClientes();
  }, []);

  return (
    <div style={styles.container}>
      <h1 style={styles.title}>CRUD de Clientes</h1>

      {mensagem && (
        <div
          style={{
            ...styles.alert,
            backgroundColor: erro ? "#ff4d4f" : "#52c41a",
          }}
        >
          {mensagem}
        </div>
      )}

      <div style={styles.grid}>
        {/* Criar */}
        <div style={styles.card}>
          <h2>Criar Cliente</h2>
          <input
            style={styles.input}
            value={nome}
            placeholder="Nome"
            onChange={(e) => setNome(e.target.value)}
          />
          <input
            style={styles.input}
            value={email}
            placeholder="Email"
            onChange={(e) => setEmail(e.target.value)}
          />
          <button style={styles.button} onClick={criarCliente}>
            Criar
          </button>
        </div>

        {/* Atualizar */}
        <div style={styles.card}>
          <h2>Atualizar Cliente</h2>
          <input
            style={styles.input}
            value={id}
            placeholder="ID"
            onChange={(e) => {
              const value = e.target.value;

              // só permite dígitos
              if (/^\d*$/.test(value)) {
                setId(value);
              }
            }}
          />
          <input
            style={styles.input}
            value={nome}
            placeholder="Nome"
            onChange={(e) => setNome(e.target.value)}
          />
          <input
            style={styles.input}
            value={email}
            placeholder="Email"
            onChange={(e) => setEmail(e.target.value)}
          />
          <button style={styles.button} onClick={atualizarCliente}>
            Atualizar
          </button>
        </div>

        {/* Deletar */}
        <div style={styles.card}>
          <h2>Deletar Cliente</h2>
          <input
            style={styles.input}
            value={id}
            placeholder="ID"
            onChange={(e) => {
              const value = e.target.value;

              // só permite dígitos
              if (/^\d*$/.test(value)) {
                setId(value);
              }
            }}
          />
          <button style={{ ...styles.button, backgroundColor: "#ff4d4f" }} onClick={deletarCliente}>
            Deletar
          </button>
        </div>
      </div>

      {/* Lista */}
      <div style={styles.listContainer}>
        <p style={{ ...styles.title, ...styles.p1 }}>Lista de Clientes</p>
        <table style={styles.table}>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            {clientes.map((c) => (
              <tr key={c.id}>
                <td style={{textAlign: "center"}}>{c.id}</td>
                <td>{c.nome}</td>
                <td>{c.email}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

/* ====== ESTILOS ====== */

const styles: any = {
  container: {
    maxWidth: 900,
    margin: "40px auto",
    fontFamily: "Arial, sans-serif",
  },
  title: {
    fontSize: 38,
    color: "blue",
    textAlign: "center",
    fontWeight: "bold",
    marginBottom: 20,

  },
  grid: {
    display: "grid",
    gridTemplateColumns: "1fr 1fr 1fr",
    gap: 20,
    marginBottom: 30,
  },
  card: {
    padding: 20,
    borderRadius: 8,
    boxShadow: "0 2px 8px rgba(0,0,0,0.1)",
    backgroundColor: "#c4c1c1",
    display: "flex",
    flexDirection: "column",
    gap: 10,
  },
  input: {
    padding: 8,
    borderRadius: 4,
    border: "2px solid #ccc",
    backgroundColor: "#d8d7d7",
    textColor: "#000",
    color: "#000",
  },
  button: {
    padding: 10,
    border: "none",
    borderRadius: 4,
    backgroundColor: "#1677ff",
    color: "#fff",
    cursor: "pointer",
  },
  alert: {
    padding: 10,
    color: "#fff",
    borderRadius: 4,
    marginBottom: 20,
    textAlign: "center",
  },
  listContainer: {
    marginTop: 20,
  },
  table: {
    width: "100%",
    borderCollapse: "collapse",
  },

  p1: {
    fontSize: 18,
  },
};